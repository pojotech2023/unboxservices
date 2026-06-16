<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MobileBrand;
use App\Models\MobileModel;
use App\Models\MobileVariant;
use App\Models\VariantQuestion;
use App\Models\VariantDefect;
use App\Models\VariantProblem;
use App\Models\VariantAccessory;
use App\Models\LaptopBrand;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\DeviceEvaluation;
use Illuminate\Http\Request;
use App\Models\CustomerLogin;          // ← add this use at the top of controller


class SellController extends Controller
{
    private string $apiKey = 'e7f41997-e54a-11f0-a6b2-0200cd936042';

    public function index()
    {
        $brands = MobileBrand::withCount('models')->get();
        return view('sell.index', compact('brands'));
    }

    public function index1()
    {
        $brands       = MobileBrand::withCount('models')->get();
        $laptopBrands = LaptopBrand::withCount('models')->get();
        return view('index1', compact('brands', 'laptopBrands'));
    }

    public function brandModels($brandSlug)
    {
        $brand  = MobileBrand::where('slug', $brandSlug)->firstOrFail();
        $models = $brand->models()->get();
        $brands = MobileBrand::all();
        return view('sell.models', compact('brand', 'models', 'brands'));
    }

    public function modelVariants($brandSlug, $modelSlug)
    {
        $brand    = MobileBrand::where('slug', $brandSlug)->firstOrFail();
        $model    = MobileModel::where('slug', $modelSlug)
                               ->where('mobile_brand_id', $brand->id)
                               ->firstOrFail();
        $variants = $model->variants()->get();
        $brands   = MobileBrand::all();

        if ($variantId = request('variant')) {
            return redirect()->route('sell.evaluate', [$brandSlug, $modelSlug, $variantId]);
        }

        return view('sell.variants', compact('brand', 'model', 'variants', 'brands'));
    }

    public function evaluate($brandSlug, $modelSlug, $variantId)
    {
        $brand   = MobileBrand::where('slug', $brandSlug)->firstOrFail();
        $model   = MobileModel::where('slug', $modelSlug)
                              ->where('mobile_brand_id', $brand->id)
                              ->firstOrFail();
        $variant = MobileVariant::where('id', $variantId)
                                 ->where('mobile_model_id', $model->id)
                                 ->firstOrFail();

        $questions = VariantQuestion::all();
        $brands    = MobileBrand::all();

        return view('sell.evaluate', compact('brand', 'model', 'variant', 'questions', 'brands'));
    }

    public function evaluateSubmit(Request $request, $brandSlug, $modelSlug, $variantId)
    {
        $brand   = MobileBrand::where('slug', $brandSlug)->firstOrFail();
        $model   = MobileModel::where('slug', $modelSlug)
                              ->where('mobile_brand_id', $brand->id)
                              ->firstOrFail();
        $variant = MobileVariant::where('id', $variantId)
                                 ->where('mobile_model_id', $model->id)
                                 ->firstOrFail();

        $questions = VariantQuestion::where('mobile_variant_id', $variant->id)
                                    ->orderBy('sort_order')
                                    ->get();

        $rules = [];
        foreach ($questions as $q) {
            $rules['answers.' . $q->id] = 'required|in:yes,no';
        }
        $request->validate($rules);

        $answers = $request->input('answers', []);
        session(['eval_answers_' . $variantId => $answers]);

        $brands       = MobileBrand::all();
        $answeredList = [];
        foreach ($questions as $q) {
            $ans            = $answers[$q->id] ?? null;
            $answeredList[] = [
                'question'    => $q->question,
                'answer'      => $ans,
                'answer_text' => $ans === 'yes' ? $q->yes_answer : $q->no_answer,
            ];
        }

        return view('sell.evaluate_result', compact('brand', 'model', 'variant', 'answeredList', 'brands'));
    }

    public function submitEvaluate(Request $request, $brandSlug, $modelSlug, $variantId)
    {
        session(['sell_answers_' . $variantId => $request->input('answers', [])]);
        return redirect()->route('sell.defects', [$brandSlug, $modelSlug, $variantId]);
    }

    // STEP 1: Defects page
    public function defects($brandSlug, $modelSlug, $variantId)
    {
        $brand   = MobileBrand::where('slug', $brandSlug)->firstOrFail();
        $model   = MobileModel::where('slug', $modelSlug)
                               ->where('mobile_brand_id', $brand->id)->firstOrFail();
        $variant = MobileVariant::where('id', $variantId)
                               ->where('mobile_model_id', $model->id)->firstOrFail();

        $defects      = VariantDefect::orderBy('sort_order')->get();
        $savedAnswers = session('sell_answers_' . $variantId, []);
        $questionIds  = array_keys($savedAnswers);
        $questions    = VariantQuestion::whereIn('id', $questionIds)->orderBy('sort_order')->get();
        $brands       = MobileBrand::all();

        return view('sell.defects', compact('brand', 'model', 'variant', 'defects', 'questions', 'savedAnswers', 'brands'));
    }

    public function menuBrands()
    {
        $brands = MobileBrand::select('id', 'name', 'slug', 'logo')->get();
        return response()->json($brands);
    }

    public function submitDefects(Request $request, $brandSlug, $modelSlug, $variantId)
    {
        $defectIds = $request->input('defect_ids', []);
        $noDefects = $request->input('no_defects');

        session(['sell_defect_ids_' . $variantId => $defectIds]);
        session(['sell_no_defects_' . $variantId => $noDefects]);

        if ($noDefects || empty($defectIds)) {
            return redirect()->route('sell.problems', [$brandSlug, $modelSlug, $variantId]);
        }

        return redirect()->route('sell.defect.sections', [$brandSlug, $modelSlug, $variantId, 'step' => 0]);
    }

    // STEP 2: Defect sub-sections
    public function defectSections(Request $request, $brandSlug, $modelSlug, $variantId)
    {
        $brand   = MobileBrand::where('slug', $brandSlug)->firstOrFail();
        $model   = MobileModel::where('slug', $modelSlug)->where('mobile_brand_id', $brand->id)->firstOrFail();
        $variant = MobileVariant::where('id', $variantId)->where('mobile_model_id', $model->id)->firstOrFail();

        $defectIds = session('sell_defect_ids_' . $variantId, []);
        if (empty($defectIds)) {
            return redirect()->route('sell.defects', [$brandSlug, $modelSlug, $variantId]);
        }

        $step = (int) $request->query('step', 0);
        $step = max(0, min($step, count($defectIds) - 1));

        $selectedDefects = VariantDefect::whereIn('id', $defectIds)
            ->orderByRaw('FIELD(id, ' . implode(',', array_map('intval', $defectIds)) . ')')
            ->get();

        $currentDefect = $selectedDefects[$step];
        $sections      = $currentDefect->sections()->with('images')->get();
        $isLast        = ($step === count($defectIds) - 1);

        $savedAnswers  = session('sell_answers_' . $variantId, []);
        $questionIds   = array_keys($savedAnswers);
        $evalQuestions = VariantQuestion::whereIn('id', $questionIds)->orderBy('sort_order')->get();
        $brands        = MobileBrand::all();

        return view('sell.defect-sections', compact(
            'brand', 'model', 'variant',
            'selectedDefects', 'currentDefect', 'sections',
            'step', 'isLast',
            'savedAnswers', 'evalQuestions', 'brands'
        ));
    }

    public function submitDefectSections(Request $request, $brandSlug, $modelSlug, $variantId)
    {
        $step     = (int) $request->input('step', 0);
        $defectId = $request->input('defect_id');
        $sections = $request->input('sections', []);

        $allSectionAnswers            = session('sell_section_answers_' . $variantId, []);
        $allSectionAnswers[$defectId] = $sections;
        session(['sell_section_answers_' . $variantId => $allSectionAnswers]);

        $defectIds = session('sell_defect_ids_' . $variantId, []);
        $nextStep  = $step + 1;

        if ($nextStep < count($defectIds)) {
            return redirect()->route('sell.defect.sections', [$brandSlug, $modelSlug, $variantId, 'step' => $nextStep]);
        }

        return redirect()->route('sell.problems', [$brandSlug, $modelSlug, $variantId]);
    }

    // STEP 4: Problems page
    public function problems($brandSlug, $modelSlug, $variantId)
    {
        $brand   = MobileBrand::where('slug', $brandSlug)->firstOrFail();
        $model   = MobileModel::where('slug', $modelSlug)->where('mobile_brand_id', $brand->id)->firstOrFail();
        $variant = MobileVariant::where('id', $variantId)->where('mobile_model_id', $model->id)->firstOrFail();

        $problems      = VariantProblem::all();
        $savedAnswers  = session('sell_answers_' . $variantId, []);
        $questionIds   = array_keys($savedAnswers);
        $evalQuestions = VariantQuestion::whereIn('id', $questionIds)->orderBy('sort_order')->get();

        $defectIds       = session('sell_defect_ids_' . $variantId, []);
        $selectedDefects = VariantDefect::whereIn('id', $defectIds)->get();

        $brands = MobileBrand::all();

        return view('sell.problems', compact(
            'brand', 'model', 'variant',
            'problems', 'savedAnswers', 'evalQuestions',
            'selectedDefects', 'brands'
        ));
    }

    public function submitProblems(Request $request, $brandSlug, $modelSlug, $variantId)
    {
        session(['sell_problem_ids_' . $variantId => $request->input('problem_ids', [])]);
        session(['sell_no_problems_'  . $variantId => $request->input('no_problems')]);

        return redirect()->route('sell.accessories', [$brandSlug, $modelSlug, $variantId]);
    }

    // STEP 6: Accessories page
    public function accessories($brandSlug, $modelSlug, $variantId)
    {
        $brand   = MobileBrand::where('slug', $brandSlug)->firstOrFail();
        $model   = MobileModel::where('slug', $modelSlug)->where('mobile_brand_id', $brand->id)->firstOrFail();
        $variant = MobileVariant::where('id', $variantId)->where('mobile_model_id', $model->id)->firstOrFail();

        $accessories = VariantAccessory::orderBy('sort_order')->get();

        $savedAnswers  = session('sell_answers_' . $variantId, []);
        $questionIds   = array_keys($savedAnswers);
        $evalQuestions = VariantQuestion::all();

        $defectIds       = session('sell_defect_ids_'      . $variantId, []);
        $selectedDefects = VariantDefect::whereIn('id', $defectIds)->get();
        $sectionAnswers  = session('sell_section_answers_' . $variantId, []);

        $problemIds       = session('sell_problem_ids_' . $variantId, []);
        $selectedProblems = VariantProblem::whereIn('id', $problemIds)->get();

        $brands = MobileBrand::all();
        $evaluationPrice = $this->resolveEvaluationPriceForVariant($model, $variantId, $variant->price);

        return view('sell.accessories', compact(
            'brand', 'model', 'variant',
            'accessories',
            'savedAnswers', 'evalQuestions',
            'selectedDefects', 'sectionAnswers',
            'selectedProblems',
            'brands', 'evaluationPrice'
        ));
    }

    // OTP: Send
    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile' => ['required', 'digits:10'],
            'name'   => ['required', 'string', 'max:100'],
        ]);

        $mobile = $request->mobile;
        $name   = $request->name;
        $otp    = random_int(100000, 999999);

        Session::put('otp_data', [
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
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send OTP. Please try again.',
                ], 422);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'SMS service unavailable. Please try again.',
            ], 503);
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully to +91 ' . $mobile,
        ]);
    }

    // OTP: Verify
    public function verifyOtp(Request $request)
{
    $request->validate([
        'otp' => ['required', 'digits:6'],
    ]);
 
    $stored = Session::get('otp_data');
 
    if (!$stored) {
        return response()->json([
            'success' => false,
            'message' => 'Session expired. Please request a new OTP.',
        ], 422);
    }
 
    if (now()->timestamp > $stored['expires_at']) {
        Session::forget('otp_data');
        return response()->json([
            'success' => false,
            'message' => 'OTP has expired. Please request a new one.',
        ], 422);
    }
 
    if ($request->otp !== $stored['otp']) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid OTP. Please try again.',
        ], 422);
    }
 
    // ✅ Create or update customer in customerlogin table
    $customer = CustomerLogin::updateOrCreate(
        ['mobile' => $stored['mobile']],        // find by mobile
        [
            'name'       => $stored['name'],
            'mobile'     => $stored['mobile'],
            'last_login' => now(),
        ]
    );
 
    // ✅ Store in session so navbar can read it
    Session::put('customer', [
        'id'     => $customer->id,
        'name'   => $customer->name,
        'mobile' => $customer->mobile,
    ]);
 
    Session::forget('otp_data');
 
    return response()->json([
        'success' => true,
        'message' => 'OTP verified successfully.',
        'name'    => $customer->name,
    ]);
}
public function logout()
{
    Session::forget('customer');
    Session::forget('otp_data');
    Session::forget('otp_verified');
 
    return redirect()->route('sell.index');
}

    // STEP 7: Final submit — saves everything to DB
   public function submitFinal(Request $request, string $brandSlug, string $modelSlug, int $variantId)
{
    // ── 1. Resolve logged-in customer from session ──────────────────────────
    $customer = Session::get('customer');
 
    if (!$customer) {
        // Fallback: accept phone/name from POST (after fresh OTP verify in modal)
        $request->validate([
            'phone' => ['required', 'digits:10'],
            'name'  => ['required', 'string', 'max:100'],
        ]);
        $mobile = $request->input('phone');
        $name   = $request->input('name');
 
        // Upsert customer record
        $customerRecord = \App\Models\CustomerLogin::updateOrCreate(
            ['mobile' => $mobile],
            ['name' => $name, 'mobile' => $mobile, 'last_login' => now()]
        );
 
        Session::put('customer', [
            'id'     => $customerRecord->id,
            'name'   => $customerRecord->name,
            'mobile' => $customerRecord->mobile,
        ]);
 
        $customer = Session::get('customer');
    } else {
        $mobile = $customer['mobile'];
        $name   = $customer['name'];
    }
 
    // ── 2. Fetch brand / model / variant ────────────────────────────────────
    $brand   = \App\Models\MobileBrand::where('slug', $brandSlug)->firstOrFail();
    $model   = \App\Models\MobileModel::where('slug', $modelSlug)
                          ->where('mobile_brand_id', $brand->id)
                          ->firstOrFail();
    $variant = \App\Models\MobileVariant::where('id', $variantId)
                             ->where('mobile_model_id', $model->id)
                             ->firstOrFail();
 
    $price = $this->resolveEvaluationPriceForVariant($model, $variantId, $variant->price);
 
    // ── 3. Pull ALL evaluation data from session ─────────────────────────────
    $evalAnswers    = session('sell_answers_'         . $variantId, []);
    $defectIds      = session('sell_defect_ids_'      . $variantId, []);
    $sectionAnswers = session('sell_section_answers_' . $variantId, []);
    $problemIds     = session('sell_problem_ids_'     . $variantId, []);
 
    // ── 4. Parse accessory IDs ───────────────────────────────────────────────
    $accessoryIds = [];
    if ($request->filled('accessory_ids')) {
        $accessoryIds = array_values(array_filter(
            array_map('intval', explode(',', $request->input('accessory_ids')))
        ));
    }
 
    // ── 5. Build answers payload ─────────────────────────────────────────────
    $answersPayload = [
        'eval_answers'    => $evalAnswers,
        'defect_ids'      => $defectIds,
        'section_answers' => $sectionAnswers,
        'problem_ids'     => $problemIds,
        'accessory_ids'   => $accessoryIds,
    ];
 
    // ── 6. Save evaluation to DB ─────────────────────────────────────────────
    $evaluation = \App\Models\DeviceEvaluation::create([
        'customer_name'   => $name,
        'customer_mobile' => $mobile,
        'brand_id'        => $brand->id,
        'model_id'        => $model->id,
        'variant_id'      => $variantId,
        'device_type'     => 'mobile',
        'answers'         => $answersPayload,
        'estimated_price' => $price,
        'status'          => 'pending',
        'otp_verified'    => true,
        'otp_verified_at' => now(),
    ]);
 
    // ── 7. Save accessories to pivot table if relation exists ────────────────
    if (!empty($accessoryIds) && method_exists($evaluation, 'accessories')) {
        $evaluation->accessories()->sync($accessoryIds);
    }
 
    // ── 8. Clear session data for this variant ───────────────────────────────
    Session::forget([
        'sell_answers_'         . $variantId,
        'sell_defect_ids_'      . $variantId,
        'sell_section_answers_' . $variantId,
        'sell_problem_ids_'     . $variantId,
        'sell_no_defects_'      . $variantId,
        'sell_no_problems_'     . $variantId,
    ]);
 
    // ── 9. Store quote data in session ──────────────────────────────────────
    session([
        'sell_eval_success' => [
            'evaluation_id' => $evaluation->id,
            'name'          => $name,
            'mobile'        => $mobile,
            'brand'         => $brand->name,
            'brand_slug'    => $brand->slug,
            'model'         => $model->name,
            'model_slug'    => $model->slug,
            'variant'       => $variant->memory,
            'price'         => $price,
            'base_price'    => $price,
            'deduction'     => 0,
            'accessories'   => $accessoryIds,
            'defects'       => $defectIds,
            'problems'      => $problemIds,
            'model_image'   => $model->image,
        ]
    ]);

    return redirect()->route('sell.phone.quote', [$brand->slug, $model->slug, $evaluation->id]);
}

public function phoneQuote(Request $request, string $brandSlug, string $modelSlug, int $evaluationId)
{
    $evaluation = \App\Models\DeviceEvaluation::with(['brand', 'model', 'variant'])->findOrFail($evaluationId);
    $customer = Session::get('customer');

    if (!$customer || ($customer['mobile'] ?? null) !== $evaluation->customer_mobile) {
        return redirect()->route('sell.phone')->withErrors(['auth' => 'Unauthorized access.']);
    }

    $brand = MobileBrand::where('slug', $brandSlug)->firstOrFail();
    $model = MobileModel::where('slug', $modelSlug)
        ->where('mobile_brand_id', $brand->id)
        ->firstOrFail();

    $data = session('sell_eval_success', []);
    if (empty($data) || (int) ($data['evaluation_id'] ?? 0) !== $evaluation->id) {
        $data = [
            'evaluation_id' => $evaluation->id,
            'name'          => $evaluation->customer_name,
            'mobile'        => $evaluation->customer_mobile,
            'brand'         => $brand->name,
            'brand_slug'    => $brand->slug,
            'model'         => $model->name,
            'model_slug'    => $model->slug,
            'variant'       => $evaluation->variant->memory ?? '',
            'price'         => (float) $evaluation->estimated_price,
            'base_price'    => (float) $evaluation->estimated_price,
            'deduction'     => 0,
            'accessories'   => [],
            'defects'       => [],
            'problems'      => [],
            'model_image'   => $model->image,
        ];
    }

    return view('sell.mobile-quote', compact('brand', 'model', 'evaluation', 'data', 'customer'));
}

public function phoneCheckout(Request $request, int $evaluationId)
{
    $evaluation = \App\Models\DeviceEvaluation::with(['brand', 'model', 'variant'])->findOrFail($evaluationId);
    $customer = Session::get('customer');

    if (!$customer || ($customer['mobile'] ?? null) !== $evaluation->customer_mobile) {
        return redirect()->route('sell.phone')->withErrors(['auth' => 'Unauthorized access.']);
    }

    return view('sell.mobile-checkout', compact('evaluation', 'customer'));
}

public function submitPhoneAddress(Request $request, int $evaluationId)
{
    $request->validate([
        'pincode'          => ['required', 'digits:6'],
        'flat_no'          => ['required', 'string', 'max:255'],
        'locality'         => ['required', 'string', 'max:255'],
        'landmark'         => ['nullable', 'string', 'max:255'],
        'city'             => ['required', 'string', 'max:100'],
        'alternate_number' => ['nullable', 'digits:10'],
        'address_type'     => ['required', 'in:home,office,other'],
        'pickup_slot'      => ['required', 'string', 'max:100'],
        'payment_method'   => ['required', 'in:cash,upi,bank'],
    ]);

    $evaluation = \App\Models\DeviceEvaluation::findOrFail($evaluationId);
    $customer = Session::get('customer');

    if (!$customer || ($customer['mobile'] ?? null) !== $evaluation->customer_mobile) {
        return redirect()->route('sell.phone')->withErrors(['auth' => 'Unauthorized access.']);
    }

    $evaluation->update([
        'pincode'          => $request->input('pincode'),
        'flat_no'          => $request->input('flat_no'),
        'locality'         => $request->input('locality'),
        'landmark'         => $request->input('landmark'),
        'city'             => $request->input('city'),
        'alternate_number' => $request->input('alternate_number'),
        'address_type'     => $request->input('address_type'),
        'pickup_slot'      => $request->input('pickup_slot'),
        'payment_method'   => $request->input('payment_method'),
        'status'           => 'confirmed',
        'otp_verified'     => true,
        'otp_verified_at'  => $evaluation->otp_verified_at ?? now(),
    ]);

    $existing = session('sell_eval_success', []);
    session([
        'sell_eval_success' => array_merge($existing, [
            'address_confirmed' => true,
            'pincode'           => $request->input('pincode'),
            'flat_no'           => $request->input('flat_no'),
            'locality'          => $request->input('locality'),
            'landmark'          => $request->input('landmark'),
            'city'              => $request->input('city'),
            'pickup_slot'       => $request->input('pickup_slot'),
            'payment_method'    => $request->input('payment_method'),
        ])
    ]);

    return redirect()->route('sell.success');
}

    private function resolveEvaluationPriceForVariant(MobileModel $model, int $variantId, float $fallbackPrice): float
    {
        $pricing = $model->evaluationPricing;
        if (!$pricing) {
            return $fallbackPrice;
        }

        $answers = session('sell_answers_' . $variantId, []);
        if (empty($answers)) {
            return $fallbackPrice;
        }

        $totalAnswers = count($answers);
        $yesCount = count(array_filter($answers, fn ($answer) => $answer === 'yes'));
        $noCount = count(array_filter($answers, fn ($answer) => $answer === 'no'));

        if ($yesCount === $totalAnswers) {
            return (float) $pricing->full_positive_price;
        }

        if ($noCount === $totalAnswers) {
            return (float) $pricing->full_negative_price;
        }

        return (float) $pricing->mixed_price;
    }
}
