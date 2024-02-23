<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\InspectorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Brand;
use App\Models\Membership;
use App\Models\Vehicle;
use PhpParser\Builder\Trait_;

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

Route::post('/addadress', [UserController::class, 'addAddress'])->name('address.post');

Route::get('/', [WelcomeController::class, 'index'], function () {
    return view('welcome');
})->name('welcome');

Route::get('/main',  [MainController::class, 'index'], function(){
    return view('layout.main');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/admin/listvehicle', [VehicleController::class, 'myvehicle'])->name('admin.myvehicle');
    Route::get('/inspector/listvehicle', [VehicleController::class, 'myvehicle'])->name('inspector.myvehicle');
    Route::get('/vehicle/myvehicle', [VehicleController::class, 'myvehicle'])->name('vehicle.myvehicle');

    Route::get('/vehicle/adddata', [VehicleController::class, 'toFormAddVehicle'])->name('vehicle.addvehicle');
    Route::post('add-vehicle', [VehicleController::class, 'store'])->name('vehicle.store');
    Route::post('/type', [VehicleController::class, 'type'])->name('type');
    Route::get('/vehicle/setupauction/{id}', [VehicleController::class, 'auctionSetupBtn'])->name('auctionSetupBtn');
    Route::put('/vehicle/auctionsetup/{id}', [VehicleController::class, 'auctionSetup'])->name('auctionSetup');

    Route::post('registermember', [MembershipController::class, 'store'])->name('membership.store');
    Route::get('/membership/register', [MembershipController::class, 'register']);
    Route::get('/cancel_post/{id}', [MembershipController::class, 'cancel_post'])->name('cancel_post');
    Route::get('/membership/bilings', [MembershipController::class, 'myBilings'])->name('membership.myBilings');
    Route::get('/update-membership-statuses', [MembershipController::class, 'expired_post'])->name('expired_post');
    Route::get('/pay-member/{id}', [MembershipController::class, 'paymentPaid'])->name('payment-post');
    Route::get('/approve/{id}', [VehicleController::class, 'approve'])->name('approve_post');
    Route::get('/vehicle/inspectionappointment/{id}', [VehicleController::class, 'appointment'])->name('vehicle.appointment');
    Route::put('/appointmentDate/{id}', [VehicleController::class, 'appointmentDate'])->name('appointmentDate');
    Route::get('/approveauctions/{id}', [VehicleController::class, 'approveAuction'])->name('vehicle.approveautions');

    Route::get('/appointmentconfirmation/{id}', [VehicleController::class, 'acceptAppointment'])->name('acceptAppointment');
    Route::get('/inspector/inspec/{id}', [VehicleController::class, 'inspec'])->name('inspector.inspec');
    Route::put('/inspections/{id}', [VehicleController::class, 'inspections'])->name('inspector.inspections');
    Route::get('/inspector/finishgrade/{id}', [VehicleController::class, 'finishGrading'])->name('finishGrading');

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'],function () {
        return view('admin.dashboard');
    })->name('admindashboard');
    Route::get('/admin/listseller', [AdminController::class, 'listSeller'])->name('admin.listseller');
    Route::get('/approveseller/{id}', [AdminController::class, 'approveSeller'])->name('admin.approve');
    Route::get('/suspendseller/{id}', [AdminController::class, 'suspendSeller'])->name('admin.suspend');
    Route::get('/user', [AdminController::class, 'listUser']);
    Route::get('/loan-list', [AdminController::class, 'loanList']);
    Route::get('/approve-loan/{id}', [AdminController::class, 'approveLoan'])->name('loan.approve');
    Route::get('/reject-loan/{id}', [AdminController::class, 'rejectLoan'])->name('loan.reject');
    Route::get('/admin/reviewvehicle/{id}', [AdminController::class, 'adminEdit'])->name('vehicle.adminEdit');

    Route::get('/inspector/dashboard', [InspectorController::class, 'dashboardIndex'], function () {
        return view('inspector.dashboard');
    })->name('inspectordashboard');
    Route::get('/appointmentlist', [InspectorController::class, 'appointmentList'])->name('appointmentlist');
    Route::post('/appointments', [InspectorController::class, 'appointmentCreate'])->name('inspector.appointmentCreate');

    Route::get('/seller/dashboard', [SellerController::class, 'dashboard'], function(){
        return view('seller.dashboard');
    })->name('sellerdashboard');
    Route::get('/orderlist', [SellerController::class, 'orderList']);
    Route::get('/seller/listsparepart', [SellerController::class, 'listSparepart'])->name('seller.sparepartlist');
    Route::get('/seller/edit-sparepart/{id}', [SellerController::class, 'sparepartEditForm'])->name('sparepart.editform');
    Route::put('sparepart-update/{id}', [SellerController::class, 'sparepartUpdate'])->name('seller.update-sparepart');

    Route::get('/seller/add-sparepart', [SparepartController::class, 'sparepartCategories'], function() {
        return view('seller.addsparepart');
    });
    Route::post('add-sparepart', [SparepartController::class, 'addSparepart'])->name('seller.add-sparepart');
    Route::delete('spareparts/{id}', [SparePartController::class, 'destroy'])->name('sparepart.destroy');
    Route::post('/add-wishlist/{id}', [SparepartController::class, 'addToWishlist'])->name('wishlist.post');
    Route::delete('/delete-wishlist/{id}', [SparepartController::class, 'removeWishlist'])->name('wishlist.destroy');
    Route::get('/wishlist',[SparepartController::class, 'wishlistIndex']);

    Route::get('/cart', [TransactionController::class, 'cartIndex']);
    Route::get('checkout', [TransactionController::class, 'checkout']);
    Route::delete('/remove-cart/{id}', [TransactionController::class, 'deletefromCart'])->name('cart.destroy');
    Route::post('/increment-product-quantity/{id}', [TransactionController::class, 'incrementProductQuantity'])->name('increment.quantity');
    Route::post('/decrement-product-quantity/{id}', [TransactionController::class, 'decrementProductQuantity'])->name('decrement.quantity');
    Route::post('add-cart/{id}', [TransactionController::class, 'addNewCart'])->name('details.addcart');
    Route::post('sparepart/add-cart/{id}', [TransactionController::class, 'addToCart'])->name('sparepart.addcart');
    Route::post('sparepart/add-wishlist/{id}', [TransactionController::class, 'addToWishlist'])->name('sparepart.addwishlist');
    Route::post('/createorder', [TransactionController::class, 'createOrderSparepart'])->name('order.post');
    Route::get('/payment/{id}', [TransactionController::class, 'paymentIndex']);
    Route::get('/approve-order/{id}', [TransactionController::class, 'approveOrder'])->name('approve_post');
    Route::get('/delivery-order/{id}', [TransactionController::class, 'onDelivery'])->name('delivery_post');
    Route::get('/payment-paid/{id}', [TransactionController::class, 'paymentPaid'])->name('payment_post');
    Route::get('/payment-cancel/{id}', [TransactionController::class, 'paymentCancel'])->name('payment_cancel');
    Route::get('/orderhistory', [TransactionController::class, 'transactionList']);
    Route::post('/order/order-details', [TransactionController::class, 'transactionDetails'])->name('transaction.details');

    Route::get('/seller/register', [UserController::class, 'toSellerRegister']);
    Route::post('become-seller', [UserController::class, 'becomeSeller'])->name('seller.register');

    Route::get('/profile', [UserController::class, 'profile']);
    Route::post('/set-primary-address/{id?}', [UserController::class, 'setPrimaryAddress'])
    ->name('primary.address');
    Route::post('/regency', [UserController::class, 'regency'])->name('regency');
    Route::post('/district', [UserController::class, 'district'])->name('district');
    Route::post('/village', [UserController::class, 'village'])->name('village');

    Route::post('/auction/add-bid/{id}', [AuctionController::class, 'placeBid'])->name('place_bid');
    Route::get('/auction', [AuctionController::class, 'auctionlist']);
    Route::get('/auctioncheckout/{id}', [AuctionController::class, 'auctionCheckout'])->name('auction.checkout');
    Route::post('/createauctionorder/{id}', [AuctionController::class, 'auctionOrders'])->name('auctionorder.post');
    Route::get('/paymentauction/{id}', [AuctionController::class, 'paymentIndex']);
    Route::get('/auction-paid/{id}', [AuctionController::class, 'paymentPaid'])->name('payment.post');
    Route::get('/approveauction-order/{id}', [AuctionController::class, 'approveOrder'])->name('approveauction.post');
    Route::get('/deliverytowings-order/{id}', [AuctionController::class, 'onDelivery'])->name('deliveryauction.post');
    Route::get('/loan/{id}', [AuctionController::class, 'loan'])->name('loan.get');
    Route::post('/loan-apply/{id}', [AuctionController::class, 'applyLoan'])->name('loan.post');
    Route::get('/down-payment/{id}', [AuctionController::class, 'payDownPayment']);
    Route::get('/downpayment-paid/{id}', [AuctionController::class, 'downPaymentPaid'])->name('downpayment.post');
    Route::get('/myloan/{id}', [AuctionController::class, 'myLoan'])->name('downpayment.get');
    Route::get('/monthly-payment/{id}', [AuctionController::class, 'monthlyPayment']);
    Route::get('/monthlypayment-paid/{id}', [AuctionController::class, 'monthlyPaymentPaid'])->name('monthlypayment.post');

    Route::get('/towing', [ShippingController::class, 'towingList']);
    Route::post('distance-create', [ShippingController::class, 'createTowPackage'])->name('distance.post');
});

Route::get('/vehicle/car', [VehicleController::class, 'car']);
Route::get('/vehicle/motorcycle', [VehicleController::class, 'motorcycle']);
Route::get('/vehicle/details/{id}', [VehicleController::class, 'show'])->name('vehicle.show');
Route::get('/vehicle/myvehicle', [VehicleController::class, 'myvehicle'])->name('vehicle.myvehicle');

Route::get('/sparepart', [SparepartController::class, 'index']);
Route::get('/sparepart/details/{id}', [SparepartController::class, 'show'])->name('sparepart.show');


Route::get('/seller/profile/{id}', [SellerController::class, 'sellerProfile'])->name('seller.profile');
