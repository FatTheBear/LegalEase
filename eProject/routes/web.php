<?php

use App\Http\Controllers\{
    HomeController, AuthController, AdminController, LawyerController, 
    CustomerController, AppointmentController, AnnouncementController, FaqController
};

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// 🔐 Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔄 Forgot password
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// 🧑‍⚖️ Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/lawyers', [AdminController::class, 'lawyers'])->name('admin.lawyers');
    Route::get('/appointments', [AdminController::class, 'appointments'])->name('admin.appointments');
    Route::resource('/announcements', AnnouncementController::class);
    Route::resource('/faqs', FaqController::class);
});

// ⚖️ Lawyer routes
Route::middleware(['auth', 'role:lawyer'])->prefix('lawyer')->group(function () {
    Route::get('/dashboard', [LawyerController::class, 'dashboard'])->name('lawyer.dashboard');
    Route::resource('/appointments', AppointmentController::class);
    Route::get('/profile', [LawyerController::class, 'edit'])->name('lawyer.profile');
    Route::post('/profile', [LawyerController::class, 'update']);
    Route::resource('/availabilities', \App\Http\Controllers\AvailabilityController::class);
});

// 👤 Customer routes
Route::middleware(['auth', 'role:customer'])->prefix('customer')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
    Route::resource('/appointments', AppointmentController::class);
});
