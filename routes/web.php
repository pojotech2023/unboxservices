<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MobileBrandController;
use App\Http\Controllers\Admin\MobileModelController;
use App\Http\Controllers\Admin\MobileVariantController;
use App\Http\Controllers\Admin\VariantQuestionsController;
use App\Http\Controllers\Admin\DefectController;
use App\Http\Controllers\Admin\DefectSectionController;
use App\Http\Controllers\Admin\DefectSectionImageControlle;
use App\Http\Controllers\Admin\VariantProblemController;   // ← 'controllers' → 'Controllers' fix
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SellController;
use App\Http\Controllers\Admin\LaptopBrandController;
use App\Http\Controllers\Admin\LaptopModelController;
use App\Http\Controllers\Admin\LaptopVariantController;
use App\Http\Controllers\Admin\LaptopSystemConfigController; // ← Admin namespace fix
use App\Http\Controllers\SellLaptopController;
use App\Http\Controllers\Admin\AccessoryController;
use App\Http\Controllers\Admin\AdminLaptopQuestionController;
use App\Http\Controllers\Admin\MobileEvaluationController;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use App\Models\VariantAccessory;
use App\Http\Controllers\Admin\LaptopEvaluationController;

// ─────────────────────────────────────────────────────────────────────────────
// PUBLIC Routes
// ─────────────────────────────────────────────────────────────────────────────

Route::get('/',                                   [SellController::class, 'index1'])->name('sell.index');
Route::get('/sell-phone',                         [SellController::class, 'index'])->name('sell.phone');
Route::get('/sell-phone/checkout/{evaluationId}',
    [SellController::class, 'phoneCheckout'])->name('sell.phone.checkout');
Route::get('/sell-phone/{brandSlug}',             [SellController::class, 'brandModels'])->name('sell.brand.models');
Route::get('/sell-phone/{brandSlug}/{modelSlug}', [SellController::class, 'modelVariants'])->name('sell.model.variants');
// Route::post('/sell/send-otp',   [SellController::class, 'sendOtp'])->name('sell.otp.send');
// Route::post('/sell/verify-otp', [SellController::class, 'verifyOtp'])->name('sell.otp.verify');
Route::get('/sell-phone/{brandSlug}/{modelSlug}/variant/{variantId}/evaluate',
    [SellController::class, 'evaluate'])->name('sell.evaluate');
Route::post('/sell/send-otp',   [SellController::class, 'sendOtp'])->name('sell.send-otp');
Route::post('/sell/verify-otp', [SellController::class, 'verifyOtp'])->name('sell.verify-otp');
Route::get('/sell/logout',      [SellController::class, 'logout'])->name('sell.logout');


Route::post('/sell-phone/{brandSlug}/{modelSlug}/variant/{variantId}/evaluate',
    [SellController::class, 'submitEvaluate'])->name('sell.evaluate.submit');
Route::get('/sell-laptop/success', [SellLaptopController::class, 'success'])->name('sell.laptop.success');
Route::get('/sell-phone/{brandSlug}/{modelSlug}/variant/{variantId}/defects',
    [SellController::class, 'defects'])->name('sell.defects');

Route::post('/sell-phone/{brandSlug}/{modelSlug}/variant/{variantId}/defects',
    [SellController::class, 'submitDefects'])->name('sell.defects.submit');

Route::get('/sell-phone/{brandSlug}/{modelSlug}/variant/{variantId}/defect-sections',
    [SellController::class, 'defectSections'])->name('sell.defect.sections');

Route::post('/sell-phone/{brandSlug}/{modelSlug}/variant/{variantId}/defect-sections',
    [SellController::class, 'submitDefectSections'])->name('sell.defect.sections.submit');

Route::get('/sell-phone/{brandSlug}/{modelSlug}/variant/{variantId}/problems',
    [SellController::class, 'problems'])->name('sell.problems');

Route::post('/sell-phone/{brandSlug}/{modelSlug}/variant/{variantId}/problems',
    [SellController::class, 'submitProblems'])->name('sell.problems.submit');

Route::get('/sell-phone/{brandSlug}/{modelSlug}/variant/{variantId}/accessories',
    [SellController::class, 'accessories'])->name('sell.accessories');

Route::post('/sell-phone/{brandSlug}/{modelSlug}/variant/{variantId}/final',
    [SellController::class, 'submitFinal'])->name('sell.final.submit');

Route::get('/sell-phone/{brandSlug}/{modelSlug}/quote/{evaluationId}',
    [SellController::class, 'phoneQuote'])->name('sell.phone.quote');

Route::post('/sell-phone/checkout/{evaluationId}/submit-address',
    [SellController::class, 'submitPhoneAddress'])->name('sell.phone.checkout.submit');

// Mobile Success Page
Route::get('/sell/success', function () {
    $data = session('sell_eval_success');
 
    if (empty($data)) {
        return redirect()->route('sell.index');
    }
 
    return view('sell.mobile-success', [
        'evaluation_id'     => $data['evaluation_id'] ?? null,
        'name'              => $data['name']          ?? 'Customer',
        'mobile'            => $data['mobile']        ?? '',
        'brand'             => $data['brand']          ?? '',
        'model'             => $data['model']          ?? '',
        'variant'           => $data['variant']       ?? '',
        'price'             => $data['price']          ?? 0,
        'accessories'       => $data['accessories']    ?? [],
        'defects'           => $data['defects']       ?? [],
        'problems'          => $data['problems']      ?? [],
        'model_image'       => $data['model_image']   ?? null,
        'address_confirmed'  => $data['address_confirmed'] ?? false,
        'pincode'           => $data['pincode']       ?? '',
        'flat_no'           => $data['flat_no']       ?? '',
        'locality'          => $data['locality']      ?? '',
        'landmark'          => $data['landmark']      ?? '',
        'city'              => $data['city']          ?? '',
        'alternate_number'  => $data['alternate_number'] ?? '',
        'address_type'      => $data['address_type']  ?? '',
        'pickup_slot'       => $data['pickup_slot']   ?? '',
        'payment_method'    => $data['payment_method'] ?? '',
    ]);
})->name('sell.success');
// ── Sell Laptop (Frontend) ────────────────────────────────────────────────────
// Route::prefix('sell-laptop')->name('sell.laptop.')->group(function () {
//     Route::get('/',                        [SellLaptopController::class, 'index'])         ->name('index');
//     Route::get('/{brandSlug}',             [SellLaptopController::class, 'brandModels'])   ->name('brand.models');
//     Route::get('/{brandSlug}/{modelSlug}', [SellLaptopController::class, 'modelVariants']) ->name('model.variants');
//     Route::get('/{brandSlug}/{modelSlug}/evaluate',
//         [SellLaptopController::class, 'evaluate'])->name('evaluate');
//     Route::get('/{brandSlug}/{modelSlug}/system-config',
//         [SellLaptopController::class, 'systemConfig'])->name('system-config');
//     Route::get('/{brandSlug}/{modelSlug}/login-required',
//         [SellLaptopController::class, 'loginRequired'])->name('login-required');
// });
Route::prefix('sell-laptop')->name('sell.laptop.')->group(function () {
    
    // Browse Flow
    Route::get('/', [SellLaptopController::class, 'index'])->name('index');
    Route::get('/{brandSlug}', [SellLaptopController::class, 'brandModels'])->name('brand.models');
    Route::get('/{brandSlug}/{modelSlug}', [SellLaptopController::class, 'modelVariants'])->name('model.variants');
    
    // Evaluation Flow
    Route::get('/{brandSlug}/{modelSlug}/evaluate', [SellLaptopController::class, 'evaluate'])->name('evaluate');
    Route::get('/{brandSlug}/{modelSlug}/system-config', [SellLaptopController::class, 'systemConfig'])->name('system-config');
    Route::get('/{brandSlug}/{modelSlug}/additional-features', [SellLaptopController::class, 'additionalFeatures'])->name('additional-features');
    Route::get('/{brandSlug}/{modelSlug}/device-condition', [SellLaptopController::class, 'deviceCondition'])->name('device-condition');
    Route::get('/{brandSlug}/{modelSlug}/screen-condition', [SellLaptopController::class, 'screenCondition'])->name('screen-condition');
    Route::get('/{brandSlug}/{modelSlug}/accessories', [SellLaptopController::class, 'accessories'])->name('accessories');
    Route::get('/{brandSlug}/{modelSlug}/device-age', [SellLaptopController::class, 'deviceAge'])->name('device-age');
    Route::post('/{brandSlug}/{modelSlug}/system-config-submit', 
        [SellLaptopController::class, 'submitSystemConfig'])
        ->name('system-config.submit');
    // Final Step: Physical Condition with Login Popup
    Route::get('/{brandSlug}/{modelSlug}/physical-condition', [SellLaptopController::class, 'physicalCondition'])->name('physical-condition');
    Route::post('/{brandSlug}/{modelSlug}/physical-condition', [SellLaptopController::class, 'submitPhysicalCondition'])->name('physical-condition.submit');
    Route::get('/{brandSlug}/{modelSlug}/quote', [SellLaptopController::class, 'quotePage'])->name('quote');
    Route::get('/sell-laptop/checkout/{evaluationId}', [SellLaptopController::class, 'checkoutPage'])->name('checkout');
    Route::post('/sell-laptop/checkout/{evaluationId}/submit-address',  [SellLaptopController::class, 'submitAddress'])->name('submit-address');

    // OTP Routes
    Route::post('/send-otp', [SellLaptopController::class, 'sendOtp'])->name('otp.send');
    Route::post('/verify-otp', [SellLaptopController::class, 'verifyOtp'])->name('otp.verify');
    
    // Resend OTP
    Route::post('/resend-otp', [SellLaptopController::class, 'resendOtp'])->name('otp.resend');
    
    // Success Page
    Route::get('/success', [SellLaptopController::class, 'success'])->name('success');
});

// ==================== ADMIN: LAPTOP EVALUATION ROUTES ====================

Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/laptop-evaluations', [LaptopEvaluationController::class, 'index'])->name('laptop-evaluations.index');
    Route::get('/laptop-evaluations/{id}', [LaptopEvaluationController::class, 'show'])->name('laptop-evaluations.show');
    Route::delete('/laptop-evaluations/{id}', [LaptopEvaluationController::class, 'destroy'])->name('laptop-evaluations.destroy');
    Route::get('/laptop-evaluations/export/excel', [LaptopEvaluationController::class, 'export'])->name('laptop-evaluations.export');
    
});
Route::get('/{brandSlug}/{modelSlug}/conditions', [SellLaptopController::class, 'conditions'])->name('sell.laptop.conditions');
Route::get('/login', [SellLaptopController::class, 'login'])->name('login');
// ── Static Pages ──────────────────────────────────────────────────────────────
Route::get('/test',    [SellController::class, 'index1']);
Route::get('/about',   fn() => view('about'))->name('about');
Route::get('/product', fn() => view('product'))->name('product');
Route::get('/contact', fn() => view('contact'))->name('contact');
Route::get('/pdf',     fn() => view('admin.helper.pdf_quotation'))->name('pdf');

// ─────────────────────────────────────────────────────────────────────────────
// ADMIN Routes
// ─────────────────────────────────────────────────────────────────────────────

Route::prefix('admin')->group(function () {

    // ── Auth ──────────────────────────────────────────────────────────────────
    Route::get('/login',   [AuthController::class, 'showLoginForm']);
    Route::post('/login',  [AuthController::class, 'adminLogin'])->name('admin.login');
    Route::post('/logout', [AuthController::class, 'adminLogout'])->name('admin.logout');

    // ── Profile ───────────────────────────────────────────────────────────────
    Route::get('/profile',         [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile-update', [ProfileController::class, 'update'])->name('profile.update');

    // ── Authenticated Admin Routes ────────────────────────────────────────────
    Route::middleware(['auth:admin', 'checkUserRole:Admin,Supervisor'])->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'getDashboard'])->name('admin.dashboard');

        // ── Common Questions & Defects ────────────────────────────────────────
        Route::get('/questions', [VariantQuestionsController::class, 'commonIndex'])
            ->name('brands.models.variants.questions.index');
        Route::post('/questions/store', [VariantQuestionsController::class, 'storeCommonQuestions'])
            ->name('brands.models.variants.questions.store');
        Route::post('/defects/store', [VariantQuestionsController::class, 'storeCommonDefects'])
            ->name('brands.models.variants.questions.defects.store');

        // ── Questions CRUD ────────────────────────────────────────────────────
        Route::put('/mobile/questions/{question}/update',
            [VariantQuestionsController::class, 'updateQuestion'])
            ->name('brands.models.variants.questions.update');
        Route::delete('/mobile/questions/{question}/delete',
            [VariantQuestionsController::class, 'destroyQuestion'])
            ->name('brands.models.variants.questions.destroy');


        // ── Defects CRUD ──────────────────────────────────────────────────────
        Route::put('/mobile/defects/{defect}/update',
            [VariantQuestionsController::class, 'updateDefect'])
            ->name('brands.models.variants.questions.defects.update');
        Route::delete('/mobile/defects/{defect}/delete',
            [VariantQuestionsController::class, 'destroyDefect'])
            ->name('brands.models.variants.questions.defects.destroy');

     Route::prefix('evaluations/mobile')->name('admin.evaluations.mobile.')->group(function () {
        Route::get('/',         [MobileEvaluationController::class, 'index'])   ->name('index');
        Route::get('/{evaluation}', [MobileEvaluationController::class, 'show'])->name('show');
        Route::delete('/{evaluation}', [MobileEvaluationController::class, 'destroy'])->name('destroy');
        Route::get('/export',   [MobileEvaluationController::class, 'export'])  ->name('export');
    });   
        // ── Mobile Brand / Model / Variant CRUD ───────────────────────────────
        Route::prefix('mobile')->name('brands.')->group(function () {
            Route::get('/',             [MobileBrandController::class, 'index'])->name('index');
            Route::get('/create',       [MobileBrandController::class, 'create'])->name('create');
            Route::post('/',            [MobileBrandController::class, 'store'])->name('store');
            Route::get('/{brand}/edit', [MobileBrandController::class, 'edit'])->name('edit');
            Route::put('/{brand}',      [MobileBrandController::class, 'update'])->name('update');
            Route::delete('/{brand}',   [MobileBrandController::class, 'destroy'])->name('destroy');
            Route::get('/{brand}/models', [MobileBrandController::class, 'viewModels'])->name('models');

            Route::prefix('/{brand}/models')->name('models.')->group(function () {
                Route::get('/create',       [MobileModelController::class, 'create'])->name('create');
                Route::post('/',            [MobileModelController::class, 'store'])->name('store');
                Route::get('/{model}/edit', [MobileModelController::class, 'edit'])->name('edit');
                Route::put('/{model}',      [MobileModelController::class, 'update'])->name('update');
                Route::delete('/{model}',   [MobileModelController::class, 'destroy'])->name('destroy');
                Route::post('/{model}/evaluation-pricing', [MobileModelController::class, 'storeEvaluationPricing'])->name('evaluation-pricing.store');
                Route::get('/{model}/variants', [MobileModelController::class, 'viewVariants'])->name('variants');

                Route::prefix('/{model}/variants')->name('variants.')->group(function () {
                    Route::get('/create',         [MobileVariantController::class, 'create'])->name('create');
                    Route::post('/',              [MobileVariantController::class, 'store'])->name('store');
                    Route::get('/{variant}/edit', [MobileVariantController::class, 'edit'])->name('edit');
                    Route::put('/{variant}',      [MobileVariantController::class, 'update'])->name('update');
                    Route::delete('/{variant}',   [MobileVariantController::class, 'destroy'])->name('destroy');
                });
            });
        });

        // ── Defect Detail + Sections ──────────────────────────────────────────
        Route::get('/mobile/defects/{defect}',
            [DefectController::class, 'show'])->name('brands.models.variants.defects.show');
        Route::post('/mobile/defects/{defect}/sections',
            [DefectSectionController::class, 'store'])->name('brands.models.variants.defects.sections.store');
        Route::put('/mobile/defects/sections/{section}/update',
            [DefectSectionController::class, 'update'])->name('brands.models.variants.defects.sections.update');
        Route::delete('/mobile/defects/sections/{section}',
            [DefectSectionController::class, 'destroy'])->name('brands.models.variants.defects.sections.destroy');

        // ── Section Images ────────────────────────────────────────────────────
        Route::post('/mobile/defects/sections/{section}/images',
            [DefectSectionImageControlle::class, 'store'])->name('brands.models.variants.defects.sections.images.store');
        Route::put('/mobile/defects/sections/images/{image}/update',
            [DefectSectionImageControlle::class, 'update'])->name('brands.models.variants.defects.sections.images.update');
        Route::delete('/mobile/defects/sections/images/{image}',
            [DefectSectionImageControlle::class, 'destroy'])->name('brands.models.variants.defects.sections.images.destroy');

        // ── Functional / Physical Problems ────────────────────────────────────
        Route::post('/mobile/variants/problems',
            [VariantProblemController::class, 'store'])->name('brands.models.variants.problems.store');
        Route::put('/mobile/problems/{problem}/update',
            [VariantProblemController::class, 'update'])->name('brands.models.variants.problems.update');
        Route::delete('/mobile/problems/{problem}',
            [VariantProblemController::class, 'destroy'])->name('brands.models.variants.problems.destroy');

        // ── Accessories ───────────────────────────────────────────────────────
        Route::prefix('accessories')->name('admin.accessories.')->group(function () {
            Route::get('/',               [AccessoryController::class, 'index'])->name('index');
            Route::post('/',              [AccessoryController::class, 'store'])->name('store');
            Route::put('/{accessory}',    [AccessoryController::class, 'update'])->name('update');
            Route::delete('/{accessory}', [AccessoryController::class, 'destroy'])->name('destroy');
        });

        // ── Laptop Brand / Model / Variant CRUD ───────────────────────────────
        Route::prefix('laptop')->name('laptop.')->group(function () {

            // Brands
            Route::get('brands',                       [LaptopBrandController::class, 'index'])->name('brands.index');
            Route::get('brands/create',                [LaptopBrandController::class, 'create'])->name('brands.create');
            Route::post('brands',                      [LaptopBrandController::class, 'store'])->name('brands.store');
            Route::get('brands/{laptopBrand}/edit',    [LaptopBrandController::class, 'edit'])->name('brands.edit');
            Route::put('brands/{laptopBrand}',         [LaptopBrandController::class, 'update'])->name('brands.update');
            Route::delete('brands/{laptopBrand}',      [LaptopBrandController::class, 'destroy'])->name('brands.destroy');

            // Models list under brand
            Route::get('brands/{laptopBrand}/models',
                [LaptopBrandController::class, 'viewModels'])->name('brands.models.index');
            Route::get('brands/{laptopBrand}/models/create',
                [LaptopModelController::class, 'create'])->name('brands.models.create');
            Route::post('brands/{laptopBrand}/models',
                [LaptopModelController::class, 'store'])->name('brands.models.store');
            Route::get('brands/{laptopBrand}/models/{laptopModel}/edit',
                [LaptopModelController::class, 'edit'])->name('brands.models.edit');
            Route::put('brands/{laptopBrand}/models/{laptopModel}',
                [LaptopModelController::class, 'update'])->name('brands.models.update');
            Route::delete('brands/{laptopBrand}/models/{laptopModel}',
                [LaptopModelController::class, 'destroy'])->name('brands.models.destroy');
             Route::post('brands/{laptopBrand}/models/{model}/evaluation-pricing',[LaptopModelController::class, 'evaluationPricingStore'])->name('brands.models.evaluation-pricing.store');
            // Variants
            Route::get('brands/{laptopBrand}/models/{laptopModel}/variants',
                [LaptopModelController::class, 'viewVariants'])->name('models.variants');
            Route::get('brands/{laptopBrand}/models/{laptopModel}/variants/create',
                [LaptopVariantController::class, 'create'])->name('models.variants.create');
            Route::post('brands/{laptopBrand}/models/{laptopModel}/variants',
                [LaptopVariantController::class, 'store'])->name('models.variants.store');
            Route::get('brands/{laptopBrand}/models/{laptopModel}/variants/{laptopVariant}/edit',
                [LaptopVariantController::class, 'edit'])->name('models.variants.edit');
            Route::put('brands/{laptopBrand}/models/{laptopModel}/variants/{laptopVariant}',
                [LaptopVariantController::class, 'update'])->name('models.variants.update');
            Route::delete('brands/{laptopBrand}/models/{laptopModel}/variants/{laptopVariant}',
                [LaptopVariantController::class, 'destroy'])->name('models.variants.destroy');

            // ── System Configs (Processor / RAM / Storage) ────────────────────
            Route::prefix('brands/{brand}/models/{model}/system-configs')
                ->name('models.system-configs.')
                ->group(function () {
                    Route::get('/',                  [LaptopSystemConfigController::class, 'index'])->name('index');
                    Route::get('/create',            [LaptopSystemConfigController::class, 'create'])->name('create');
                    Route::post('/',                 [LaptopSystemConfigController::class, 'store'])->name('store');
                    Route::get('/{config}/edit',     [LaptopSystemConfigController::class, 'edit'])->name('edit');
                    Route::put('/{config}',          [LaptopSystemConfigController::class, 'update'])->name('update');
                    Route::delete('/{config}',       [LaptopSystemConfigController::class, 'destroy'])->name('destroy');
                    Route::patch('/{config}/toggle', [LaptopSystemConfigController::class, 'toggleActive'])->name('toggle');
                });
        });
       
    // ... existing routes ...
    Route::get('/laptop/questions',                          [AdminLaptopQuestionController::class, 'index'])   ->name('admin.laptop.questions.index');
    Route::post('/laptop/questions',                         [AdminLaptopQuestionController::class, 'store'])   ->name('admin.laptop.questions.store');
    Route::put('/laptop/questions/{id}',                     [AdminLaptopQuestionController::class, 'update'])  ->name('admin.laptop.questions.update');
    Route::delete('/laptop/questions/{id}',                  [AdminLaptopQuestionController::class, 'destroy']) ->name('admin.laptop.questions.destroy');
    // Options
    Route::post('/laptop/questions/{qid}/options',           [AdminLaptopQuestionController::class, 'storeOption'])   ->name('admin.laptop.questions.options.store');
    Route::put('/laptop/questions/options/{oid}',            [AdminLaptopQuestionController::class, 'updateOption'])  ->name('admin.laptop.questions.options.update');
    Route::delete('/laptop/questions/options/{oid}',         [AdminLaptopQuestionController::class, 'destroyOption']) ->name('admin.laptop.questions.options.destroy');
   
    

    }); 
    // end auth middleware

}); // end admin prefix
