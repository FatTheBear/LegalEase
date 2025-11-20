<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Lawyer\LawyerController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\AppointmentController;


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

Route::get('/', [HomeController::class, 'index'])->name('home');

// Public Lawyer List (for customers to browse)
Route::get('/lawyers', [LawyerController::class, 'index'])->name('lawyers.index');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [RegisterController::class, 'showChoiceForm'])->name('register.choice');
Route::get('/register/customer', [RegisterController::class, 'showCustomerRegistrationForm'])->name('register.customer');
Route::post('/register/customer', [RegisterController::class, 'registerCustomer'])->name('register.customer.submit');

Route::get('/register/lawyer', [RegisterController::class, 'showLawyerRegistrationForm'])->name('register.lawyer');
Route::post('/register/lawyer', [RegisterController::class, 'registerLawyer'])->name('register.lawyer.submit');

// Public Lawyers List
Route::get('/lawyers', [PublicLawyerController::class, 'index'])->name('lawyers.index');
Route::get('/lawyers/{id}', [PublicLawyerController::class, 'show'])->name('lawyers.show');

// Public Routes (temporary placeholders)
Route::get('/appointments', function() {
    return redirect()->route('login');
})->name('appointments.index');

Route::get('/announcements', function() {
    return view('announcements.index');
})->name('announcements.index');

Route::get('/faqs', function() {
    return view('faqs.index');
})->name('faqs.index');

// Dashboard Routes (Protected - require auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/lawyer/dashboard', [LawyerController::class, 'dashboard'])->name('lawyer.dashboard');
    Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
    
    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [AdminController::class, 'manageUsers'])->name('users');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::get('/lawyers', [AdminController::class, 'manageLawyers'])->name('lawyers');
        Route::put('/lawyers/{id}/approve', [AdminController::class, 'approveLawyer'])->name('lawyers.approve');
        Route::put('/lawyers/{id}', [AdminController::class, 'updateLawyer'])->name('lawyers.update');
        Route::get('/appointments', [AdminController::class, 'manageAppointments'])->name('appointments');
        Route::put('/appointments/{id}', [AdminController::class, 'updateAppointment'])->name('appointments.update');
        Route::get('/announcements', [AdminController::class, 'manageAnnouncements'])->name('announcements');
    });
    
    // Appointments Routes
    Route::get('/appointments/create/{lawyer_id}', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::put('/appointments/{id}/confirm', [AppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::put('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
});
