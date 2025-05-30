<?php

use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BricksController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DeviceTokenController;
use App\Http\Controllers\Admin\Material\SandController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\OtherUtilitiesController;
use App\Http\Controllers\Admin\OtherUtilitiesSubController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\QuotationController;
use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\Admin\SubcontractorController;
use App\Http\Controllers\Admin\SupervisorCreationController;
use App\Http\Controllers\Admin\VendorController;
use App\Models\Attendance;
use App\Models\OtherUtilities;
use App\Models\OtherUtilitiesSub;
use App\Models\Subcontractor;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
// ----------------------------------------Web----------------------------------------------
Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/product', function () {
    return view('product');
})->name('product');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/pdf', function () {
    return view('admin.helper.pdf_quotation');
})->name('pdf');
//------------------------------------------ Admin-----------------------------------------------------
Route::prefix('admin')->group(function () {

    // Login and Logout
    Route::get('/login', [AuthController::class, 'showLoginForm']);
    Route::post('/login', [AuthController::class, 'adminLogin'])->name('admin.login');
    Route::post('/logout', [AuthController::class, 'adminLogout'])->name('admin.logout');

    Route::post('/save-device-token', [DeviceTokenController::class, 'store'])->name('save.device.token');

    Route::middleware(['auth:admin', 'checkUserRole:Admin,Supervisor'])->group(function () {

        //Dashboard
        Route::get('/dashboard', [DashboardController::class, 'getDashboard'])->name('admin.dashboard');

        //Customer Management
        Route::get('/customer-management', [CustomerController::class, 'index'])->name('customer.list');
        Route::get('/customer-edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
        Route::patch('/customer-update/{id}', [CustomerController::class, 'update'])->name('customer.update');
        Route::delete('/customer-delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');

        //Vendor Management
        Route::get('/vendor-management', [VendorController::class, 'index'])->name('vendor.list');
        Route::post('/vendor-add', [VendorController::class, 'store'])->name('vendor.add');
        Route::post('/vendor-update', [VendorController::class, 'update'])->name('vendor.update');
        Route::delete('/vendor-delete/{id}', [VendorController::class, 'delete'])->name('vendor.delete');
        Route::get('/vendors/search', [VendorController::class, 'search'])->name('vendors.search');

        //Vendor Dashboard
        Route::get('/vendor-dashboard', [VendorController::class, 'dashboard'])->name('vendor.dashboard');
        Route::get('/paydetail/{vendorId}', [VendorController::class, 'getPayDetailsForm'])->name('vendor.payDetailForm');
        //opening Balance
        Route::post('pay-update', [VendorController::class, 'vendorpayUpdate'])->name('paydetail.update');
        Route::post('payment-add', [VendorController::class, 'addPayment'])->name('payment.add');
        Route::get('payment-history/{vendorId}', [VendorController::class, 'paymentHistory'])->name('payment.history');

        //Supervisor Creation
        Route::get('/supervisor-management', [SupervisorCreationController::class, 'index'])->name('supervisor.list');
        Route::post('/supervisor-add', [SupervisorCreationController::class, 'store'])->name('supervisor.add');
        Route::post('/supervisor-update', [SupervisorCreationController::class, 'update'])->name('supervisor.update');
        Route::delete('/supervisor-delete/{id}', [SupervisorCreationController::class, 'delete'])->name('supervisor.delete');

        //Site Management
        Route::get('/site-form', [SiteController::class, 'getForm'])->name('site.form');
        Route::get('/site-management', [SiteController::class, 'index'])->name('sitemanagement.list');
        Route::post('/site-add', [SiteController::class, 'store'])->name('sitemanagement.add');
        Route::get('/site-edit/{id}', [SiteController::class, 'edit'])->name('sitemanagement.edit');
        Route::patch('/site-update/{id}', [SiteController::class, 'update'])->name('sitemanagement.update');
        Route::patch('/site-inactivate/{id}', [SiteController::class, 'delete'])->name('sitemanagement.delete');
        Route::get('/site-detail/{id}', [SiteController::class, 'siteDetail'])->name('site.detail');

        //Attendance
        Route::get('/attendance/{siteId}', [AttendanceController::class, 'index'])->name('attendance');
        Route::post('/add-wages', [AttendanceController::class, 'addWages'])->name('add.wages');
        Route::post('/add-attendance', [AttendanceController::class, 'addAttendance'])->name('add.attendance');

        Route::get('attendance/{siteId}/wages-form', [AttendanceController::class, 'getWagesForm'])->name('wages.form');
        Route::get('/attendance/{siteId}/form', [AttendanceController::class, 'getAttendanceForm'])->name('attendance.form');

        //Materials
        Route::get('/material-detail/{siteId}', [MaterialController::class, 'getMaterial'])->name('material.detail');

        Route::get('/material/{siteId}/{materialType}', [MaterialController::class, 'index'])->name('material');
        Route::post('/material/get-data/{siteId}', [MaterialController::class, 'getMaterialData'])->name('material.getData');

        Route::get('/material-requestForm/{siteId}/{materialType}', [MaterialController::class, 'getRequestForm'])->name('material.requestForm');
        Route::post('/request-order', [MaterialController::class, 'materialRequest'])->name('add.request');

        Route::get('/material-orderForm/{siteId}/{materialType}', [MaterialController::class, 'getOrderForm'])->name('material.orderForm');
        Route::post('/add-order', [MaterialController::class, 'materialOrder'])->name('add.order');

        //Other Utilities
        Route::get('/site-utilities/{id}', [OtherUtilitiesController::class, 'index'])->name('site.utilities');
        Route::post('/utilities-add', [OtherUtilitiesController::class, 'store'])->name('utilities.add');

        //Other Utilities Subcontractor
        Route::get('/site-subutilities/{id}', [OtherUtilitiesSubController::class, 'index'])->name('site.subutilities');
        Route::post('/subutilities-add', [OtherUtilitiesSubController::class, 'store'])->name('subutilities.add');

        //Bricks
        // Route::get('/bricks/{siteId}', [BricksController::class, 'index'])->name('bricks');
        // Route::post('/bricks/{siteId}/get-data', [BricksController::class, 'getBricksData'])->name('bricks.getData');

        // Route::get('/bricks/{siteId}/request-form', [BricksController::class, 'getRequestForm'])->name('bricks.requestForm');
        // Route::get('/bricks/{siteId}/order-form', [BricksController::class, 'getOrderForm'])->name('bricks.orderForm');
        // Route::get('/bricks/{siteId}/pay-form', [BricksController::class, 'getPayForm'])->name('bricks.payForm');

        //Subcontractor
        Route::get('/subcontractor-detail/{siteId}', [SubcontractorController::class, 'getSubcontractor'])->name('subcontractor.detail');
        //Subcontractor Plumber
        Route::get('/subcontractor/pay-list/{siteId}/{type}', [SubcontractorController::class, 'subcontractorPayList'])->name('subcontractor.payList');
        Route::post('/subcontractor/pay-add', [SubcontractorController::class, 'subcontractorAddPay'])->name('subcontractor.payAdd');
        //Subcontractor Dashboard Plumber
        Route::get('/subcontractor-dashboard', [SubcontractorController::class, 'dashboard'])->name('subcontractor.dashboard');
        Route::get('/subcontractor/payment-history/{type}', [SubcontractorController::class, 'paymentHistory'])->name('subcontractor.paymentHistory');
        Route::post('/subcontractor/payment-add', [SubcontractorController::class, 'addPayment'])->name('subcontractor.paymentAdd');

        //Agent
        Route::get('/agent-management', [AgentController::class, 'index'])->name('agent.list');
        Route::post('/agent-add', [AgentController::class, 'store'])->name('agent.add');
        Route::post('agent-update', [AgentController::class, 'update'])->name('agent.update');
        Route::patch('/agent/inactivate/{id}', [AgentController::class, 'delete'])->name('agent.delete');

        //Property list
        Route::get('/property-management', [PropertyController::class, 'index'])->name('property-list');
        Route::get('/property-form', [PropertyController::class, 'getPropertyForm'])->name('property.form');
        Route::post('/property-add', [PropertyController::class, 'store'])->name('property.add');

        //Quotation
        Route::get('/quotation-form', [QuotationController::class, 'getForm'])->name('quotation.form');
        Route::post('/quotation-add', [QuotationController::class, 'store'])->name('quotation.add');
    });
});
