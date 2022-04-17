<?php

use Illuminate\Support\Facades\Route;

// import controller

// Frontsite
use App\Http\Controllers\Frontsite\AppointmentController;
use App\Http\Controllers\Frontsite\LandingController;
use App\Http\Controllers\Frontsite\PaymentController;
use App\Http\Controllers\Frontsite\RegisterSuccessController;

// Backsite
use App\Http\Controllers\Backsite\DashboardController;
use App\Http\Controllers\Backsite\TypeUserController;
use App\Http\Controllers\Backsite\SpecialistController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::resource('/', LandingController::class);

Route::group(['middleware' => ['auth:sanctum', 'verified']], function (){

    // Payment page
    Route::resource('payment', PaymentController::class);

    // Appointment page
    Route::resource('appointment', AppointmentController::class);

});

Route::group(['prefix' => 'backsite', 'as' => 'backsite.', 'middleware' => ['auth:sanctum', 'verified']], function() {

    // dashboard
     Route::resource('dashboard', DashboardController::class);

    //  type user
     Route::resource('type_user', TypeUserController::class);

    // specialist
     Route::resource('specialist', SpecialistController::class);

});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');
