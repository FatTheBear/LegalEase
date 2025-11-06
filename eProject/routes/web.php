<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LawyerController as AdminLawyerController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Lawyer\LawyerController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\FaqController;

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// AUTH
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ADMIN
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/lawyers', [AdminLawyerController::class, 'index'])->name('admin.lawyers');
    Route::get('/appointments', [AdminAppointmentController::class, 'index'])->name('admin.appointments');
});

// LAWYER
Route::prefix('lawyers')->group(function () {
    Route::get('/', [LawyerController::class, 'index'])->name('lawyers.index');
    Route::get('/{id}', [LawyerController::class, 'show'])->name('lawyers.show');
    Route::get('/dashboard', [LawyerController::class, 'dashboard'])->middleware('auth')->name('lawyers.dashboard');
});

// CUSTOMER
Route::prefix('customers')->middleware('auth')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('customers.dashboard');
});

// APPOINTMENTS
Route::prefix('appointments')->middleware('auth')->group(function () {
    Route::get('/', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/', [AppointmentController::class, 'store'])->name('appointments.store');
});

// ANNOUNCEMENTS
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');

// FAQ
Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
