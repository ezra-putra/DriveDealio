<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\InspectorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\WelcomeController;
use App\Models\VehicleType;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Brand;
use App\Models\Membership;
use App\Models\Vehicle;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('/', [WelcomeController::class, 'index'], function () {
    return view('welcome');
})->name('welcome');

Route::get('/main', function(){
    return view('layout.main');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/admin/listvehicle', [VehicleController::class, 'myvehicle'])->name('admin.myvehicle');
    Route::get('/inspector/listvehicle', [VehicleController::class, 'myvehicle'])->name('inspector.myvehicle');
    Route::get('/vehicle/myvehicle', [VehicleController::class, 'myvehicle'])->name('vehicle.myvehicle');

    Route::get('/vehicle/adddata', [VehicleController::class, 'categorized'])->name('vehicle.categorized');
    Route::post('add-vehicle', [VehicleController::class, 'store'])->name('vehicle.store');
    Route::get('/vehicle/setupauction/{id}', [VehicleController::class, 'auctionSetupBtn'])->name('auctionSetupBtn');
    Route::put('/vehicle/auctionsetup/{id}', [VehicleController::class, 'auctionSetup'])->name('auctionSetup');

    Route::post('registermember', [MembershipController::class, 'store'])->name('membership.store');
    Route::get('/membership/register', [MembershipController::class, 'register']);
    Route::get('/cancel_post/{id}', [MembershipController::class, 'cancel_post'])->name('cancel_post');
    Route::get('/approve_post/{id}', [MembershipController::class, 'approve_post'])->name('approve_post');
    Route::get('/membership/bilings', [MembershipController::class, 'myBilings'])->name('membership.myBilings');

    Route::get('/admin/reviewvehicle/{id}', [VehicleController::class, 'adminEdit'])->name('vehicle.adminEdit');
    Route::get('/approve/{id}', [VehicleController::class, 'approve'])->name('approve_post');
    Route::get('/admin/inspectionappointment/{id}', [VehicleController::class, 'appointment'])->name('vehicle.appointment');
    Route::put('/appointmentDate/{id}', [VehicleController::class, 'appointmentDate'])->name('appointmentDate');
    Route::get('/approveauctions/{id}', [VehicleController::class, 'approveAuction'])->name('vehicle.approveautions');

    Route::get('/appointmentconfirmation/{id}', [VehicleController::class, 'acceptAppointment'])->name('acceptAppointment');
    Route::get('/inspector/inspections/{id}', [VehicleController::class, 'inspections'])->name('inspector.inspections');
    Route::put('/inspectionUpdate/{id}', [VehicleController::class, 'inspectionsUpdate'])->name('inspectionsUpdate');
    Route::get('/inspector/grading/{id}', [VehicleController::class, 'grading'])->name('inspector.grading');
    Route::put('/inspectionGrade/{id}', [VehicleController::class, 'inspectionsGrade'])->name('inspectionsGrade');
    Route::get('/inspector/finishgrade/{id}', [VehicleController::class, 'finishGrading'])->name('finishGrading');

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'],function () {
        return view('admin.dashboard');
    })->name('admindashboard');

    Route::get('/inspector/dashboard', [InspectorController::class, 'dashboardIndex'], function () {
        return view('inspector.dashboard');
    })->name('inspectordashboard');

    Route::get('/appointmentlist', [InspectorController::class, 'appointmentList'])->name('appointmentlist');
    Route::get('/appointments/add-data', function() {
        return view('inspector.addappointmentdate');
    });
    Route::post('/appointments', [InspectorController::class, 'appointmentCreate'])->name('inspector.appointmentCreate');


    Route::get('/seller/dashboard', [SellerController::class, 'dashboard'], function(){
        return view('seller.dashboard');
    })->name('sellerdashboard');
    Route::get('/seller/listsparepart', [SparepartController::class, 'listSparepart'])->name('seller.sparepartlist');

    Route::get('/seller/register', function(){
        return view('seller.sellerregister');
    });
    Route::post('become-seller', [UserController::class, 'becomeSeller'])->name('seller.register');
    Route::get('/admin/listseller', [AdminController::class, 'listSeller'])->name('admin.listseller');
    Route::get('/approveseller/{id}', [AdminController::class, 'approveSeller'])->name('admin.approve');
    Route::get('/suspendseller/{id}', [AdminController::class, 'suspendSeller'])->name('admin.suspend');

});

Route::get('/vehicle/car', [VehicleController::class, 'car']);
Route::get('/vehicle/motorcycle', [VehicleController::class, 'motorcycle']);
Route::get('/vehicle/details/{id}', [VehicleController::class, 'show'])->name('vehicle.show');
Route::get('/vehicle/myvehicle', [VehicleController::class, 'myvehicle'])->name('vehicle.myvehicle');
Route::post('/update-ad-status', [VehicleController::class, 'updateAdStatus']);
