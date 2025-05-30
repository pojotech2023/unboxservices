<?php

use App\Http\Controllers\API\AgentController;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BricksController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\DeviceTokenController;
use App\Http\Controllers\API\GenerateQuotationController;
use App\Http\Controllers\API\MaterialController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\OtherUtilitiesController;
use App\Http\Controllers\API\OtherUtilitiesSubController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\PropertyController;
use App\Http\Controllers\API\SiteController;
use App\Http\Controllers\API\SubContractorController;
use App\Http\Controllers\API\SupervisorController;
use App\Http\Controllers\API\VendorController;
use App\Models\MaterialOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your aggregator. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

//test
Route::post('/send-notification', [NotificationController::class, 'send']);

Route::middleware('auth:sanctum')->group(function () {

  //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'getDashboard']);

  //Device Token Store
  Route::post('/save-device-token', [DeviceTokenController::class, 'store']);

  //Sites
  Route::get('/site-management', [SiteController::class, 'index']);
  Route::get('/site-detail/{id}', [SiteController::class, 'siteDetail']);

  //Other Utilities
  Route::get('/site-utilities/{id}', [OtherUtilitiesController::class, 'index']); //siteId
  Route::post('/utilities-add', [OtherUtilitiesController::class, 'store']);

  //Other Utilities Subcontractor
  Route::get('/site-subutilities/{id}', [OtherUtilitiesSubController::class, 'index']);
  Route::post('/subutilities-add', [OtherUtilitiesSubController::class, 'store']);
  
  //Attendance
  Route::get('/attendance/{siteId}', [AttendanceController::class, 'index']);
  Route::post('/add-wages', [AttendanceController::class, 'addWages']);
  Route::post('/add-attendance', [AttendanceController::class, 'addAttendance']);

  //Material Details
  Route::get('/material-detail/{siteId}', [MaterialController::class, 'getMaterial']); //material quantity & vlaues
  Route::post('/material/{siteId}/{materialType}', [MaterialController::class, 'materialData']); //bricks, sand list
  Route::post('/request-order', [MaterialController::class, 'materialRequest']); //add request 
  Route::post('/add-order', [MaterialController::class, 'materialOrder']);    // add order

  //Subcontractor
  Route::get('/subcontractor-detail/{siteId}', [SubContractorController::class, 'getSubcontractor']);  //subcontractor total amount
  Route::get('/subcontractor/pay-list/{siteId}/{type}', [SubContractorController::class, 'subcontractorPayList']); //each subcontractor payment list
  Route::post('/subcontractor/pay-add', [SubContractorController::class, 'subcontractorAddPay']); //each subcontractor add payment 

  //Subcontractor Dashboard Plumber
  Route::get('/subcontractor-dashboard', [SubcontractorController::class, 'dashboard']);
  Route::get('/subcontractor/payment-history/{type}', [SubcontractorController::class, 'paymentHistory']);
  Route::post('/subcontractor/payment-add', [SubcontractorController::class, 'addPayment']);

  //Customer Management
  Route::get('/customer-management', [CustomerController::class, 'index']);
  Route::patch('/customer-update/{id}', [CustomerController::class, 'update']);
  Route::delete('/customer-delete/{id}', [CustomerController::class, 'delete']);

  //Supervisor Management
  Route::get('/supervisor-management', [SupervisorController::class, 'index']);
  Route::post('/supervisor-add', [SupervisorController::class, 'store']);
  Route::patch('/supervisor-update/{id}', [SupervisorController::class, 'update']);
  Route::delete('/supervisor-delete/{id}', [SupervisorController::class, 'delete']);

  //Vendor Management
  Route::get('/vendor-management', [VendorController::class, 'index']);
  Route::post('/vendor-add', [VendorController::class, 'store']);
  Route::patch('/vendor-update/{id}', [VendorController::class, 'update']);
  Route::delete('/vendor-delete/{id}', [VendorController::class, 'delete']);
  Route::get('/vendors/search', [VendorController::class, 'search']);

  //Vendor Dashboard
  Route::get('/vendor-dashboard', [VendorController::class, 'dashboard']);
  Route::get('/paydetail/{vendorId}', [VendorController::class, 'getPayDetailsForm']);
  Route::post('paydetail-update', [VendorController::class, 'paydetailUpdate']); //only for opening balance
  Route::post('payment-add', [VendorController::class, 'addPayment']);
  Route::get('payment-history/{vendorId}', [VendorController::class, 'paymentHistory']);

  //Agent
  Route::get('/agent-management', [AgentController::class, 'index']);
  Route::post('/agent-add', [AgentController::class, 'store']);
  Route::patch('agent-update/{id}', [AgentController::class, 'update']);
  Route::delete('/agent/inactivate/{id}', [AgentController::class, 'delete']);

  //Property list
  Route::get('/property-management', [PropertyController::class, 'index']);
  Route::post('/property-add', [PropertyController::class, 'store']);

  //Quotation
  Route::post('/quotation-add', [GenerateQuotationController::class, 'store']);

  //Profile setting
  Route::get('/profile', [ProfileController::class, 'show']);
  Route::post('/profile-update', [ProfileController::class, 'update']);
});
