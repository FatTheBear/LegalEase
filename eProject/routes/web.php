<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
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

// AUTH - Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// AUTH - Register
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showChoiceForm'])->name('register.choice');
    Route::get('/register/customer', [RegisterController::class, 'showCustomerForm'])->name('register.customer');
    Route::post('/register/customer', [RegisterController::class, 'registerCustomer'])->name('register.customer.submit');
    Route::get('/register/lawyer', [RegisterController::class, 'showLawyerForm'])->name('register.lawyer');
    Route::post('/register/lawyer', [RegisterController::class, 'registerLawyer'])->name('register.lawyer.submit');
});

// Email Verification
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['signed'])
    ->name('verification.verify');

Route::post('/email/resend', [VerificationController::class, 'resend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.resend');

// ADMIN - Chỉ admin mới truy cập được
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/lawyers', [AdminLawyerController::class, 'index'])->name('admin.lawyers');
    Route::get('/appointments', [AdminAppointmentController::class, 'index'])->name('admin.appointments');
});

// LAWYER - Chỉ lawyer mới truy cập được
Route::prefix('lawyer')->middleware(['auth', 'role:lawyer'])->group(function () {
    Route::get('/dashboard', [LawyerController::class, 'dashboard'])->name('lawyer.dashboard');
});

// CUSTOMER - Chỉ customer mới truy cập được
Route::prefix('customer')->middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
});

// PUBLIC - Danh sách luật sư (ai cũng xem được)
Route::prefix('lawyers')->group(function () {
    Route::get('/', [LawyerController::class, 'index'])->name('lawyers.index');
    Route::get('/{id}', [LawyerController::class, 'show'])->name('lawyers.show');
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
