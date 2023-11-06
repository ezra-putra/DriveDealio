<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
});
Route::get('/', function () {
    return view('welcome');
});

Route::get('/vehicle/cars', function () {
    return view('vehicle.carindex');
});

Route::get('/vehicle/addnew', function(){
    return view('vehicle.newvehicle');
});

Route::get('/user/role', [RoleController::class, 'index']);
Route::resource('user', UserController::class);
