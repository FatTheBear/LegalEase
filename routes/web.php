<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Lawyer\LawyerController;        // ← Dashboard luật sư
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\AppointmentController;
use App\Http\Controllers\Lawyer\AnnouncementController;
use App\Http\Controllers\Lawyer\AvailabilityController;
use App\Http\Controllers\Lawyer\ProfileController;
use App\Http\Controllers\NotificationController;


// ĐÃ XÓA DÒNG NÀY: use App\Http\Controllers\PublicLawyerController; ← Không tồn tại → lỗi

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// ĐÃ SỬA: Dùng đúng Lawyer\LawyerController thay vì PublicLawyerController (không tồn tại)
Route::get('/lawyers', [LawyerController::class, 'index'])->name('lawyers.index');
Route::get('/lawyers/{id}', [LawyerController::class, 'show'])->name('lawyers.show');

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

// Public placeholders
Route::get('/appointments', function() {
    return redirect()->route('login');
})->name('appointments.index');

Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');

Route::get('/faqs', function () {
    $faqs = \App\Models\Faq::all();   // hoặc Faq::latest()->get();
    return view('faqs.index', compact('faqs'));
})->name('faqs.index');

// Dashboard Routes (Protected - require auth)
Route::middleware(['auth'])->group(function () {
// ===== Dashboard chung cho mọi role =====
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/lawyer/dashboard', [LawyerController::class, 'dashboard'])->name('lawyer.dashboard');
    Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
    // Noti
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    // ===== Profile chung (customer & admin dùng) =====
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // ===== Lawyer Schedule & Profile riêng (chỉ lawyer mới vào được) =====
    Route::middleware('role:lawyer')->group(function () {
        Route::get('/lawyer/schedule', [AvailabilityController::class, 'index'])->name('lawyer.schedule');
        Route::post('/lawyer/schedule', [AvailabilityController::class, 'store']);
        Route::delete('/lawyer/schedule/{slot}', [AvailabilityController::class, 'destroy'])
            ->name('lawyer.schedule.destroy');
            
        Route::get('/lawyer/profile/edit', [App\Http\Controllers\Lawyer\ProfileController::class, 'edit'])->name('lawyer.profile.edit');
        Route::post('/lawyer/profile/update', [App\Http\Controllers\Lawyer\ProfileController::class, 'update'])->name('lawyer.profile.update');
    });
    // Admin Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard'); // nếu cần riêng
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

    Route::post('/ratings', [App\Http\Controllers\RatingController::class, 'store'])->name('ratings.store');
});