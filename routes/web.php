<?php

use Illuminate\Support\Facades\Route;

// import controller

// Frontsite
use App\Http\Controllers\Frontsite\AppointmentController;
use App\Http\Controllers\Frontsite\LandingController;
use App\Http\Controllers\Frontsite\PaymentController;

// Backsite
use App\Http\Controllers\Backsite\DashboardController;
use App\Http\Controllers\Backsite\TypeUserController;
use App\Http\Controllers\Backsite\SpecialistController;
use App\Http\Controllers\Backsite\ConsultationController;
use App\Http\Controllers\Backsite\ConfigPaymentController;
use App\Http\Controllers\Backsite\DoctorController;
use App\Http\Controllers\Backsite\PermissionController;
use App\Http\Controllers\Backsite\RoleController;
use App\Http\Controllers\Backsite\ReportAppointmentController;
use App\Http\Controllers\Backsite\ReportTransactionController;
use App\Http\Controllers\Backsite\UserController;
use App\Http\Controllers\Backsite\HospitalPaitentContoller;

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

    // Config Payment
     Route::resource('config-payment', ConfigPaymentController::class);

    // Consultation
     Route::resource('consultation', ConsultationController::class);

    // permission
     Route::resource('permission', PermissionController::class);

    // Role
     Route::resource('role', RoleController::class);

    // Appointment
     Route::resource('appointment', ReportAppointmentController::class);

    // Appointment
     Route::resource('transaction', ReportTransactionController::class);

    // Doctor
     Route::resource('doctor', DoctorController::class);

    // User
     Route::resource('user', UserController::class);

     // Hospital Patient
     Route::resource('hospital-patient', HospitalPaitentContoller::class);

});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');
