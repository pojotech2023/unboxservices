<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use App\Models\LaptopBrand;
use App\Models\LaptopModel;
use App\Models\LaptopVariant;
use App\Models\LaptopQuestion;
use App\Models\LaptopDeviceEvaluation;
use App\Models\CustomerLogin;            // ← Added: upsert on OTP verify

class SellLaptopController extends Controller
{
    private string $apiKey = 'e7f41997-e54a-11f0-a6b2-0200cd936042';

    // ==================== HELPERS ====================

    private function getBrands()
    {
        return LaptopBrand::withCount('models')->get();
    }

    /**
     * Unified login check.
     * Checks `customer` session (set by both mobile & laptop OTP verify)
     * OR legacy `laptop_otp_verified` session.
     * Always ensures both sessions are in sync.
     *
     * @return array|null  ['id'=>?, 'name'=>?, 'mobile'=>?]  or null if not logged in
     */
    private function getVerifiedCustomer(): ?array
    {
        // 1. Primary: customer session (shared between mobile & laptop flows)
        if ($customer = Session::get('customer')) {
            // Keep laptop_otp_verified in sync so old checks don't break
            if (!Session::has('laptop_otp_verified')) {
                Session::put('laptop_otp_verified', [
                    'mobile'      => $customer['mobile'],
                    'name'        => $customer['name'],
                    'verified_at' => now()->timestamp,
                ]);
            }
            return $customer;
        }

        // 2. Legacy: laptop_otp_verified session
        if ($verified = Session::get('laptop_otp_verified')) {
            // Promote to customer session so next check is faster
            $customerRecord = CustomerLogin::where('mobile', $verified['mobile'])->first();
            $customerData   = [
                'id'     => $customerRecord?->id,
                'name'   => $verified['name'],
                'mobile' => $verified['mobile'],
            ];
            Session::put('customer', $customerData);
            return $customerData;
        }

        return null;
    }

    private function getBaseParams(Request $request): array
    {
        $params = [];
        $keys   = ['variant', 'power_on', 'processor', 'ram', 'storage', 'af', 'dc', 'sc', 'acc', 'age', 'age_id'];
        foreach ($keys as $key) {
            if ($request->filled($key)) {
                $params[$key] = $request->input($key);
            }
        }
        return $params;
    }

    private function buildSummary(Request $request, int $basePrice): array
    {
        $summary = [];
        $params  = $this->getBaseParams($request);

        if (isset($params['power_on'])) {
            $summary[] = [
                'section' => 'Device Evaluation',
                'items'   => [[
                    'q'    => 'Does the Laptop switch on?',
                    'a'    => $params['power_on'] === 'yes' ? 'Yes, switches on fine' : 'No / Not sure',
                    'type' => $params['power_on'] === 'yes' ? 'good' : 'bad',
                ]],
            ];
        }

        $configItems = [];
        if (isset($params['processor'])) $configItems[] = ['q' => 'Processor', 'a' => $params['processor'], 'type' => 'good'];
        if (isset($params['ram']))       $configItems[] = ['q' => 'RAM',       'a' => $params['ram'],       'type' => 'good'];
        if (isset($params['storage']))   $configItems[] = ['q' => 'Storage',   'a' => $params['storage'],   'type' => 'good'];
        if (!empty($configItems)) {
            $summary[] = ['section' => 'System Configuration', 'items' => $configItems];
        }

        if (isset($params['af'])) {
            $afAnswers = json_decode(base64_decode($params['af']), true) ?? [];
            $items     = array_map(fn($a) => ['q' => $a['q'], 'a' => $a['a'], 'type' => 'good'], $afAnswers);
            if ($items) $summary[] = ['section' => 'Additional Features', 'items' => $items];
        }

        if (isset($params['dc'])) {
            $dcAnswers = explode(',', $params['dc']);
            $items     = array_map(fn($a) => ['q' => 'Issue', 'a' => $a, 'type' => 'bad'], $dcAnswers);
            if ($items) $summary[] = ['section' => 'Device Condition', 'items' => $items];
        }

        if (isset($params['sc'])) {
            $summary[] = ['section' => 'Screen Condition', 'items' => [['q' => 'Screen Condition', 'a' => $params['sc'], 'type' => 'good']]];
        }

        if (isset($params['acc'])) {
            $accAnswers = explode(',', $params['acc']);
            $items      = array_map(fn($a) => ['q' => 'Accessory', 'a' => $a, 'type' => 'good'], $accAnswers);
            if ($items) $summary[] = ['section' => 'Accessories', 'items' => $items];
        }

        if (isset($params['age'])) {
            $summary[] = ['section' => 'Device Age', 'items' => [['q' => 'Age', 'a' => $params['age'], 'type' => 'info']]];
        }

        return $summary;
    }

    /**
     * Calculate the correct price based on evaluation criteria.
     */
    private function calculateFinalPrice(LaptopModel $model, ?LaptopVariant $variant, Request $request): float
    {
        $basePrice = $variant ? (float) $variant->price : (float) $model->price;
        $pricing   = $model->evaluationPricing;

        if (!$pricing) {
            $deduction = (int) $request->input('deduction', 0);
            return max(0, $basePrice - $deduction);
        }

        $powerOn = $request->input('power_on', 'yes');

        if ($powerOn === 'no') {
            return (float) $pricing->full_negative_price;
        }

        $hasDeviceCondition = $request->filled('dc') && trim($request->input('dc')) !== '';
        $physicalDeduction  = (int) $request->input('deduction', 0);
        $hasPhysicalIssues  = $physicalDeduction > 0;

        if (!$hasDeviceCondition && !$hasPhysicalIssues) {
            return (float) $pricing->full_positive_price;
        }

        return (float) $pricing->mixed_price;
    }

    // ==================== BROWSE PAGES ====================

    public function index()
    {
        $brands = $this->getBrands();
        return view('sell.laptop.index', compact('brands'));
    }

    public function brandModels($brandSlug)
    {
        $brand  = LaptopBrand::where('slug', $brandSlug)->firstOrFail();
        $models = $brand->models()->get();
        $brands = $this->getBrands();
        return view('sell.laptop.models', compact('brand', 'models', 'brands'));
    }

    public function modelVariants($brandSlug, $modelSlug)
    {
        $brand    = LaptopBrand::where('slug', $brandSlug)->firstOrFail();
        $model    = LaptopModel::where('slug', $modelSlug)->where('laptop_brand_id', $brand->id)->firstOrFail();
        $variants = $model->variants()->get();
        $brands   = $this->getBrands();
        return view('sell.laptop.variants', compact('brand', 'model', 'variants', 'brands'));
    }

    // ==================== EVALUATION STEPS ====================

    public function evaluate(Request $request, $brandSlug, $modelSlug)
    {
        $brand   = LaptopBrand::where('slug', $brandSlug)->firstOrFail();
        $model   = LaptopModel::where('slug', $modelSlug)->where('laptop_brand_id', $brand->id)->firstOrFail();
        $variant = $request->filled('variant') ? $model->variants()->find($request->variant) : null;
        $brands  = $this->getBrands();
        return view('sell.laptop.evaluate', compact('brand', 'model', 'variant', 'brands'));
    }

    public function systemConfig(Request $request, $brandSlug, $modelSlug)
    {
        $brand      = LaptopBrand::where('slug', $brandSlug)->firstOrFail();
        $model      = LaptopModel::where('slug', $modelSlug)->where('laptop_brand_id', $brand->id)->firstOrFail();
        $variant    = $request->filled('variant') ? $model->variants()->find($request->variant) : null;
        $processors = $model->systemConfigs()->active()->ofType('processor')->ordered()->get();
        $rams       = $model->systemConfigs()->active()->ofType('ram')->ordered()->get();
        $storages   = $model->systemConfigs()->active()->ofType('storage')->ordered()->get();
        $powerOn    = $request->query('power_on', 'yes');

        // ── FIX: Check login via unified helper ──────────────────────────────
        $verifiedCustomer = $this->getVerifiedCustomer();
        $isVerified       = !empty($verifiedCustomer);

        return view('sell.laptop.system-config', compact(
            'brand', 'model', 'variant',
            'processors', 'rams', 'storages',
            'powerOn', 'isVerified', 'verifiedCustomer'
        ));
    }

    public function additionalFeatures(Request $request, $brandSlug, $modelSlug)
    {
        $brand     = LaptopBrand::where('slug', $brandSlug)->firstOrFail();
        $model     = LaptopModel::where('slug', $modelSlug)->where('laptop_brand_id', $brand->id)->firstOrFail();
        $variant   = $request->filled('variant') ? $model->variants()->find($request->variant) : null;
        $questions = LaptopQuestion::active()->ofGroup('additional_features')->ordered()->with('options')->get();
        $brands    = $this->getBrands();
        $summary   = $this->buildSummary($request, $variant ? $variant->price : $model->price);
        return view('sell.laptop.additional-features', compact('brand', 'model', 'variant', 'questions', 'summary', 'brands'));
    }

    public function deviceCondition(Request $request, $brandSlug, $modelSlug)
    {
        $brand     = LaptopBrand::where('slug', $brandSlug)->firstOrFail();
        $model     = LaptopModel::where('slug', $modelSlug)->where('laptop_brand_id', $brand->id)->firstOrFail();
        $variant   = $request->filled('variant') ? $model->variants()->find($request->variant) : null;
        $questions = LaptopQuestion::active()->ofGroup('device_condition')->ordered()->with('options')->get();
        $brands    = $this->getBrands();
        $summary   = $this->buildSummary($request, $variant ? $variant->price : $model->price);
        return view('sell.laptop.device-condition', compact('brand', 'model', 'variant', 'questions', 'summary', 'brands'));
    }

    public function screenCondition(Request $request, $brandSlug, $modelSlug)
    {
        $brand     = LaptopBrand::where('slug', $brandSlug)->firstOrFail();
        $model     = LaptopModel::where('slug', $modelSlug)->where('laptop_brand_id', $brand->id)->firstOrFail();
        $variant   = $request->filled('variant') ? $model->variants()->find($request->variant) : null;
        $questions = LaptopQuestion::active()->ofGroup('screen_condition')->ordered()->with('options')->get();
        $brands    = $this->getBrands();
        $summary   = $this->buildSummary($request, $variant ? $variant->price : $model->price);
        return view('sell.laptop.screen-condition', compact('brand', 'model', 'variant', 'questions', 'summary', 'brands'));
    }

    public function accessories(Request $request, $brandSlug, $modelSlug)
    {
        $brand     = LaptopBrand::where('slug', $brandSlug)->firstOrFail();
        $model     = LaptopModel::where('slug', $modelSlug)->where('laptop_brand_id', $brand->id)->firstOrFail();
        $variant   = $request->filled('variant') ? $model->variants()->find($request->variant) : null;
        $questions = LaptopQuestion::active()->ofGroup('accessories')->ordered()->with('options')->get();
        $brands    = $this->getBrands();
        $summary   = $this->buildSummary($request, $variant ? $variant->price : $model->price);
        return view('sell.laptop.accessories', compact('brand', 'model', 'variant', 'questions', 'summary', 'brands'));
    }

    public function deviceAge(Request $request, $brandSlug, $modelSlug)
    {
        $brand    = LaptopBrand::where('slug', $brandSlug)->firstOrFail();
        $model    = LaptopModel::where('slug', $modelSlug)->where('laptop_brand_id', $brand->id)->firstOrFail();
        $variant  = $request->filled('variant') ? $model->variants()->find($request->variant) : null;
        $question = LaptopQuestion::where('question_group', 'device_age')->where('is_active', 1)
                        ->with(['options' => fn($q) => $q->orderBy('sort_order')])->first();
        $summary  = $this->buildSummary($request, $variant ? $variant->price : $model->price);
        return view('sell.laptop.device_age', compact('brand', 'model', 'variant', 'question', 'summary'));
    }

    // STEP 8: Physical Condition — Final Step with Login Popup
    public function physicalCondition(Request $request, $brandSlug, $modelSlug)
    {
        $brand     = LaptopBrand::where('slug', $brandSlug)->firstOrFail();
        $model     = LaptopModel::where('slug', $modelSlug)->where('laptop_brand_id', $brand->id)->firstOrFail();
        $variant   = $request->filled('variant') ? $model->variants()->find($request->variant) : null;
        $questions = LaptopQuestion::where('question_group', 'physical_condition')
                        ->where('is_active', 1)
                        ->with(['options' => fn($q) => $q->orderBy('sort_order')])
                        ->orderBy('sort_order')->get();
        $summary   = $this->buildSummary($request, $variant ? $variant->price : $model->price);

        // ── FIX: Use unified helper ──────────────────────────────────────────
        $verifiedCustomer = $this->getVerifiedCustomer();
        $isVerified       = !empty($verifiedCustomer);
        $allParams        = $request->all();

        return view('sell.laptop.device_condition_physical', compact(
            'brand', 'model', 'variant', 'questions', 'summary',
            'isVerified', 'verifiedCustomer', 'allParams'
        ));
    }

    // ==================== OTP METHODS ====================

    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile' => ['required', 'digits:10', 'regex:/^[6-9]\d{9}$/'],
            'name'   => ['required', 'string', 'max:100', 'min:2'],
        ]);

        $mobile = $request->mobile;
        $name   = $request->name;
        $otp    = random_int(100000, 999999);

        Session::put('laptop_otp_data', [
            'otp'        => (string) $otp,
            'mobile'     => $mobile,
            'name'       => $name,
            'expires_at' => now()->addMinutes(10)->timestamp,
        ]);

        try {
            $response = Http::timeout(10)->get(
                "https://2factor.in/API/V1/{$this->apiKey}/SMS/{$mobile}/{$otp}"
            );
            $body = $response->json();
            if (($body['Status'] ?? '') !== 'Success') {
                Log::error('2Factor API Error', ['response' => $body]);
                return response()->json(['success' => false, 'message' => 'Failed to send OTP. Please try again.'], 422);
            }
        } catch (\Exception $e) {
            Log::error('OTP Send Exception', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'SMS service temporarily unavailable.'], 503);
        }

        return response()->json(['success' => true, 'message' => 'OTP sent to +91 ' . $mobile]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => ['required', 'digits:6']]);

        $stored = Session::get('laptop_otp_data');

        if (!$stored) {
            return response()->json(['success' => false, 'message' => 'Session expired. Please request a new OTP.'], 422);
        }
        if (now()->timestamp > $stored['expires_at']) {
            Session::forget('laptop_otp_data');
            return response()->json(['success' => false, 'message' => 'OTP has expired. Please request a new one.'], 422);
        }
        if ($request->otp !== $stored['otp']) {
            return response()->json(['success' => false, 'message' => 'Invalid OTP. Please try again.'], 422);
        }

        // ── FIX: Upsert CustomerLogin + set shared customer session ──────────
        $customerRecord = CustomerLogin::updateOrCreate(
            ['mobile' => $stored['mobile']],
            [
                'name'       => $stored['name'],
                'mobile'     => $stored['mobile'],
                'last_login' => now(),
            ]
        );

        // Store in laptop_otp_verified (legacy — some views still read this)
        Session::put('laptop_otp_verified', [
            'mobile'      => $stored['mobile'],
            'name'        => $stored['name'],
            'verified_at' => now()->timestamp,
        ]);

        // Store in shared customer session (used by mobile flow + getVerifiedCustomer())
        Session::put('customer', [
            'id'     => $customerRecord->id,
            'name'   => $customerRecord->name,
            'mobile' => $customerRecord->mobile,
        ]);

        Session::forget('laptop_otp_data');

        return response()->json([
            'success'  => true,
            'message'  => 'OTP verified successfully.',
            'customer' => ['name' => $stored['name'], 'mobile' => $stored['mobile']],
        ]);
    }

    public function resendOtp(Request $request)
    {
        $stored = Session::get('laptop_otp_data');
        if (!$stored) {
            return response()->json(['success' => false, 'message' => 'Session expired. Please start again.'], 422);
        }

        $mobile = $stored['mobile'];
        $name   = $stored['name'];
        $otp    = random_int(100000, 999999);

        Session::put('laptop_otp_data', [
            'otp'        => (string) $otp,
            'mobile'     => $mobile,
            'name'       => $name,
            'expires_at' => now()->addMinutes(10)->timestamp,
        ]);

        try {
            $response = Http::timeout(10)->get("https://2factor.in/API/V1/{$this->apiKey}/SMS/{$mobile}/{$otp}");
            $body     = $response->json();
            if (($body['Status'] ?? '') !== 'Success') {
                return response()->json(['success' => false, 'message' => 'Failed to resend OTP.'], 422);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'SMS service unavailable.'], 503);
        }

        return response()->json(['success' => true, 'message' => 'OTP resent successfully.']);
    }

    // ==================== FINAL SUBMIT ====================

    public function submitPhysicalCondition(Request $request, $brandSlug, $modelSlug)
    {
        // ── FIX: Use unified helper ──────────────────────────────────────────
        $verifiedCustomer = $this->getVerifiedCustomer();

        if ($verifiedCustomer) {
            $mobile      = $verifiedCustomer['mobile'];
            $name        = $verifiedCustomer['name'];
            $otpVerified = true;
        } else {
            $request->validate([
                'phone' => ['required', 'digits:10'],
                'name'  => ['required', 'string', 'max:100', 'min:2'],
            ]);
            $mobile      = $request->phone;
            $name        = $request->name;
            $otpVerified = false;
        }

        $brand   = LaptopBrand::where('slug', $brandSlug)->firstOrFail();
        $model   = LaptopModel::where('slug', $modelSlug)->where('laptop_brand_id', $brand->id)->firstOrFail();
        $variant = $request->filled('variant') ? $model->variants()->find($request->variant) : null;

        $basePrice      = $variant ? (float) $variant->price : (float) $model->price;
        $finalPrice     = $this->calculateFinalPrice($model, $variant, $request);
        $totalDeduction = max(0, $basePrice - $finalPrice);

        $answers = [
            'power_on'            => $request->input('power_on'),
            'processor'           => $request->input('processor'),
            'ram'                 => $request->input('ram'),
            'storage'             => $request->input('storage'),
            'additional_features' => $request->filled('af') ? json_decode(base64_decode($request->af), true) : [],
            'device_condition'    => $request->filled('dc') ? explode(',', $request->dc) : [],
            'screen_condition'    => $request->input('sc'),
            'accessories'         => $request->filled('acc') ? explode(',', $request->acc) : [],
            'device_age'          => $request->input('age'),
            'physical_condition'  => json_decode($request->input('answers', '{}'), true),
            'total_deduction'     => $totalDeduction,
            'base_price'          => $basePrice,
        ];

        $evaluation = LaptopDeviceEvaluation::create([
            'customer_name'     => $name,
            'customer_mobile'   => $mobile,
            'laptop_brand_id'   => $brand->id,
            'laptop_model_id'   => $model->id,
            'laptop_variant_id' => $variant?->id,
            'answers'           => $answers,
            'base_price'        => $basePrice,
            'total_deduction'   => $totalDeduction,
            'estimated_price'   => $finalPrice,
            'status'            => 'pending',
            'otp_verified'      => $otpVerified,
            'otp_verified_at'   => $otpVerified ? now() : null,
        ]);

        session([
            'laptop_eval_success' => [
                'evaluation_id' => $evaluation->id,
                'name'          => $name,
                'mobile'        => $mobile,
                'brand'         => $brand->name,
                'brand_slug'    => $brand->slug,
                'model'         => $model->name,
                'model_slug'    => $model->slug,
                'model_image'   => $model->image,
                'variant'       => $variant ? "{$variant->storage} / {$variant->ram}" : null,
                'price'         => $finalPrice,
                'base_price'    => $basePrice,
                'deduction'     => $totalDeduction,
            ],
        ]);

        return redirect()->route('sell.laptop.quote', [$brand->slug, $model->slug]);
    }

    // ==================== QUOTE PAGE ====================

    public function quotePage(Request $request, $brandSlug, $modelSlug)
    {
        $data = session('laptop_eval_success');

        if (!$data || ($data['brand_slug'] ?? '') !== $brandSlug) {
            return redirect()->route('sell.laptop.index');
        }

        $brand = LaptopBrand::where('slug', $brandSlug)->firstOrFail();
        $model = LaptopModel::where('slug', $modelSlug)->where('laptop_brand_id', $brand->id)->firstOrFail();

        // Pass customer info to view
        $verifiedCustomer = $this->getVerifiedCustomer();

        return view('sell.laptop.quote', compact('brand', 'model', 'data', 'verifiedCustomer'));
    }

    // ==================== CHECKOUT / ADDRESS ====================

    public function checkoutPage(Request $request, $evaluationId)
    {
        $evaluation = LaptopDeviceEvaluation::with(['brand', 'laptopModel'])->findOrFail($evaluationId);
        $data       = session('laptop_eval_success', []);

        // ── FIX: Use unified helper ──────────────────────────────────────────
        $verifiedCustomer = $this->getVerifiedCustomer();

        if (!$verifiedCustomer || $verifiedCustomer['mobile'] !== $evaluation->customer_mobile) {
            return redirect()->route('sell.laptop.index')->withErrors(['auth' => 'Unauthorized access.']);
        }

        return view('sell.laptop.checkout', compact('evaluation', 'data', 'verifiedCustomer'));
    }

    public function submitAddress(Request $request, $evaluationId)
    {
        $request->validate([
            'pincode'          => 'required|digits:6',
            'flat_no'          => 'required|string|max:255',
            'locality'         => 'required|string|max:255',
            'landmark'         => 'nullable|string|max:255',
            'city'             => 'required|string|max:100',
            'alternate_number' => 'nullable|digits:10',
            'address_type'     => 'required|in:home,office,other',
            'pickup_slot'      => 'required|string|max:100',
            'payment_method'   => 'required|in:cash,upi,bank',
        ]);

        $evaluation = LaptopDeviceEvaluation::findOrFail($evaluationId);

        // ── FIX: Use unified helper ──────────────────────────────────────────
        $verifiedCustomer = $this->getVerifiedCustomer();

        if (!$verifiedCustomer || $verifiedCustomer['mobile'] !== $evaluation->customer_mobile) {
            return redirect()->route('sell.laptop.index')->withErrors(['auth' => 'Unauthorized.']);
        }

        $evaluation->update([
            'pincode'          => $request->pincode,
            'flat_no'          => $request->flat_no,
            'locality'         => $request->locality,
            'landmark'         => $request->landmark,
            'city'             => $request->city,
            'alternate_number' => $request->alternate_number,
            'address_type'     => $request->address_type,
            'pickup_slot'      => $request->pickup_slot,
            'payment_method'   => $request->payment_method,
            'status'           => 'confirmed',
        ]);

        $existing = session('laptop_eval_success', []);
        session(['laptop_eval_success' => array_merge($existing, [
            'address_confirmed' => true,
            'pickup_slot'       => $request->pickup_slot,
            'city'              => $request->city,
        ])]);

        return redirect()->route('sell.laptop.success');
    }

    // ==================== SUCCESS ====================

    public function success()
    {
        $data = session('laptop_eval_success', [
            'name'    => 'Customer',
            'mobile'  => '',
            'brand'   => '',
            'model'   => '',
            'variant' => '',
            'price'   => 0,
        ]);
        return view('sell.laptop.success', $data);
    }

    // ==================== SYSTEM CONFIG SUBMIT ====================

    public function submitSystemConfig(Request $request, $brandSlug, $modelSlug)
    {
        $powerOn = $request->input('power_on', 'yes');

        if ($powerOn === 'yes') {
            $params = $request->only(['variant', 'power_on', 'processor', 'ram', 'storage']);
            $query  = http_build_query(array_filter($params));
            return response()->json([
                'success'      => true,
                'redirect_url' => route('sell.laptop.additional-features', [$brandSlug, $modelSlug]) . '?' . $query,
            ]);
        }

        // ── power_on = NO: FIX: Use unified helper ───────────────────────────
        $verifiedCustomer = $this->getVerifiedCustomer();

        if (!$verifiedCustomer) {
            return response()->json(['success' => false, 'message' => 'Please verify OTP first.'], 422);
        }

        $brand   = LaptopBrand::where('slug', $brandSlug)->firstOrFail();
        $model   = LaptopModel::where('slug', $modelSlug)->where('laptop_brand_id', $brand->id)->firstOrFail();
        $variant = $request->filled('variant') ? $model->variants()->find($request->variant) : null;

        $basePrice  = $variant ? (float) $variant->price : (float) $model->price;
        $pricing    = $model->evaluationPricing;
        $finalPrice = $pricing ? (float) $pricing->full_negative_price : $basePrice;

        $answers = [
            'power_on'            => 'no',
            'processor'           => $request->input('processor'),
            'ram'                 => $request->input('ram'),
            'storage'             => $request->input('storage'),
            'additional_features' => [],
            'device_condition'    => [],
            'screen_condition'    => null,
            'accessories'         => [],
            'device_age'          => null,
            'physical_condition'  => [],
            'total_deduction'     => 0,
            'base_price'          => $basePrice,
        ];

        $evaluation = LaptopDeviceEvaluation::create([
            'customer_name'     => $verifiedCustomer['name'],
            'customer_mobile'   => $verifiedCustomer['mobile'],
            'laptop_brand_id'   => $brand->id,
            'laptop_model_id'   => $model->id,
            'laptop_variant_id' => $variant?->id,
            'answers'           => $answers,
            'base_price'        => $basePrice,
            'total_deduction'   => 0,
            'estimated_price'   => $finalPrice,
            'status'            => 'confirmed',
            'otp_verified'      => true,
            'otp_verified_at'   => now(),
        ]);

        session([
            'laptop_eval_success' => [
                'evaluation_id' => $evaluation->id,
                'name'          => $verifiedCustomer['name'],
                'mobile'        => $verifiedCustomer['mobile'],
                'brand'         => $brand->name,
                'brand_slug'    => $brand->slug,
                'model'         => $model->name,
                'model_slug'    => $model->slug,
                'model_image'   => $model->image,
                'variant'       => $variant ? "{$variant->storage} / {$variant->ram}" : null,
                'price'         => $finalPrice,
                'base_price'    => $basePrice,
                'deduction'     => 0,
                'message'       => 'Our team member will come to your address and check to give you the exact price.',
            ],
        ]);

        return response()->json([
            'success'      => true,
            'redirect_url' => route('sell.laptop.quote', [$brand->slug, $model->slug]),
        ]);
    }
}