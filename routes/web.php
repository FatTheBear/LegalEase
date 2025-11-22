<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Lawyer\LawyerController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\AppointmentController as CustomerAppointmentController;


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
Route::get('/lawyers', [LawyerController::class, 'index'])->name('lawyers.index');
Route::get('/lawyers/{id}', [LawyerController::class, 'show'])->name('lawyers.show');

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
    Route::get('/lawyer/dashboard', [LawyerController::class, 'dashboard'])->name('lawyer.dashboard')->middleware('role:lawyer');
    Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard')->middleware('role:customer');
    
    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // User Management
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::put('/users/{id}/activate', [UserController::class, 'activate'])->name('users.activate');
        Route::put('/users/{id}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
        Route::put('/users/{id}/ban', [UserController::class, 'ban'])->name('users.ban');
        
        // Lawyer Management
        Route::get('/lawyers', [AdminController::class, 'manageLawyers'])->name('lawyers');
        Route::get('/lawyers/{id}', [AdminController::class, 'showLawyerProfile'])->name('lawyers.show');
        Route::put('/lawyers/{id}/approve', [AdminController::class, 'approveLawyer'])->name('lawyers.approve');
        Route::put('/lawyers/{id}/reject', [AdminController::class, 'rejectLawyer'])->name('lawyers.reject');
        Route::put('/lawyers/{id}', [AdminController::class, 'updateLawyer'])->name('lawyers.update');
        
        // Appointment Management
        Route::get('/appointments', [AdminAppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/{id}', [AdminAppointmentController::class, 'show'])->name('appointments.show');
        Route::get('/appointments/{id}/edit', [AdminAppointmentController::class, 'edit'])->name('appointments.edit');
        Route::put('/appointments/{id}', [AdminAppointmentController::class, 'update'])->name('appointments.update');
        Route::put('/appointments/{id}/confirm', [AdminAppointmentController::class, 'confirm'])->name('appointments.confirm');
        Route::put('/appointments/{id}/cancel', [AdminAppointmentController::class, 'cancel'])->name('appointments.cancel');
        Route::delete('/appointments/{id}', [AdminAppointmentController::class, 'destroy'])->name('appointments.destroy');
        
        // Announcement Management
        Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
        Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
        Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
        Route::get('/announcements/{id}', [AnnouncementController::class, 'show'])->name('announcements.show');
        Route::get('/announcements/{id}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
        Route::put('/announcements/{id}', [AnnouncementController::class, 'update'])->name('announcements.update');
        Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
    });
    
    // Appointments Routes
    Route::get('/appointments/create/{lawyer_id}', [CustomerAppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [CustomerAppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments', [CustomerAppointmentController::class, 'index'])->name('appointments.index');
    Route::put('/appointments/{id}/confirm', [CustomerAppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::put('/appointments/{id}/cancel', [CustomerAppointmentController::class, 'cancel'])->name('appointments.cancel');
});
