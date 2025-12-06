<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Lawyer\LawyerController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\AppointmentController;
use App\Http\Controllers\Lawyer\AnnouncementController;
use App\Http\Controllers\Lawyer\AvailabilityController;
use App\Http\Controllers\Lawyer\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\LandingController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\Admin\LawyerScheduleController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/lawyers', [LawyerController::class, 'index'])->middleware('auth')->name('lawyers.index');
Route::get('/lawyers/{id}', [LawyerController::class, 'show'])->middleware('auth')->name('lawyers.show');


Route::get('/lawyers/{id}/slots/{date}', [LawyerController::class, 'getSlotsByDay'])
    ->middleware('auth')
    ->name('lawyer.slots.by.day');


// ==================== CÁC ROUTE KHÔNG CẦN LOGIN (PHẢI RA NGOÀI) ====================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showChoiceForm'])->name('register.choice');
Route::get('/register/customer', [RegisterController::class, 'showCustomerRegistrationForm'])->name('register.customer');
Route::post('/register/customer', [RegisterController::class, 'registerCustomer'])->name('register.customer.submit');
Route::get('/register/lawyer', [RegisterController::class, 'showLawyerRegistrationForm'])->name('register.lawyer');
Route::post('/register/lawyer', [RegisterController::class, 'registerLawyer'])->name('register.lawyer.submit');

// Email Verification Routes
Route::get('/email/verify/{id}/{hash}', [\App\Http\Controllers\Auth\VerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/resend', [\App\Http\Controllers\Auth\VerificationController::class, 'resend'])->name('verification.resend');

Route::get('/announcements', [AnnouncementController::class, 'index'])->middleware('auth')->name('announcements.index');
Route::get('/faqs', function () {
    $faqs = \App\Models\Faq::all();
    return view('faqs.index', compact('faqs'));
})->middleware('auth')->name('faqs.index');

Route::get('/landing', [\App\Http\Controllers\Admin\LandingController::class, 'index'])->name('landing');

// ==================== CHỈ TỪ ĐÂY MỚI CẦN ĐĂNG NHẬP ====================
Route::middleware(['auth'])->group(function () {

    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create/{lawyer_id}', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::put('/appointments/{id}/confirm', [AppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::put('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

    // Rating route
    Route::post('/appointments/{appointment}/rate', [RatingController::class, 'store'])
        ->name('ratings.store');
    
    // Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/lawyer/dashboard', [LawyerController::class, 'dashboard'])->name('lawyer.dashboard');
    Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    Route::get('/lawyer/profile/edit', [ProfileController::class, 'edit'])
    ->name('lawyer.profile.edit');

Route::post('/lawyer/profile/update', [ProfileController::class, 'update'])
    ->name('lawyer.profile.update');

Route::middleware('role:lawyer')->group(function () {

    Route::get('/lawyer/schedule', [AvailabilityController::class,'index'])
        ->name('lawyer.schedule');

    Route::post('/lawyer/schedule', [AvailabilityController::class,'store'])
        ->name('lawyer.schedule.store');

    Route::delete('/lawyer/schedule/toggle/{id}', [AvailabilityController::class,'destroy'])
        ->name('lawyer.schedule.toggle');

    Route::get('/lawyer/schedule/json', [AvailabilityController::class,'getSlots'])
        ->name('lawyer.schedule.json');

    Route::get('/lawyer/schedule/day/{date}', [AvailabilityController::class,'getSlotsByDay'])
        ->name('lawyer.schedule.by-day');

    Route::post('/lawyer/schedule/create-day', [AvailabilityController::class,'storeDay'])
        ->name('lawyer.schedule.create-day');

    Route::delete('/lawyer/schedule/delete-day/{date}', [AvailabilityController::class,'destroyDay'])
        ->name('lawyer.schedule.delete-day');

});


    // Admin Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard'); // nếu cần riêng
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::put('/users/{id}/activate', [UserController::class, 'activate'])->name('users.activate');
        Route::put('/users/{id}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
        Route::get('/users/{id}/ban', [UserController::class, 'ban'])->name('users.ban');
        // Lawyers management
        Route::get('/lawyers', [AdminController::class, 'manageLawyers'])->name('lawyers.index');
        // Custom actions first (more specific)
        Route::put('/lawyers/{id}/approve', [AdminController::class, 'approveLawyer'])->name('lawyers.approve');
        Route::post('/lawyers/{id}/approve', [AdminController::class, 'approveLawyer']);
        Route::put('/lawyers/{id}/reject', [AdminController::class, 'rejectLawyer'])->name('lawyers.reject');
        Route::post('/lawyers/{id}/reject', [AdminController::class, 'rejectLawyer']);
        Route::match(['put', 'post'], '/lawyers/{id}/change-status', [AdminController::class, 'updateLawyerStatus'])->name('lawyers.update-status');
        Route::delete('/lawyers/{id}', [AdminController::class, 'deleteLawyer'])->name('lawyers.delete');
        Route::post('/lawyers/{id}', [AdminController::class, 'deleteLawyer']);
        Route::put('/lawyers/{id}', [AdminController::class, 'updateLawyer'])->name('lawyers.update');
        Route::get('/lawyers/{id}', [AdminController::class, 'showLawyerProfile'])->name('lawyers.show');
        
        // Appointment Management
        Route::get('/appointments', [AdminAppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/{id}', [AdminAppointmentController::class, 'show'])->name('appointments.show');
        Route::get('/appointments/{id}/edit', [AdminAppointmentController::class, 'edit'])->name('appointments.edit');
        Route::put('/appointments/{id}', [AdminAppointmentController::class, 'update'])->name('appointments.update');
        Route::put('/appointments/{id}/confirm', [AdminAppointmentController::class, 'confirm'])->name('appointments.confirm');
        Route::put('/appointments/{id}/cancel', [AdminAppointmentController::class, 'cancel'])->name('appointments.cancel');
        Route::delete('/appointments/{id}', [AdminAppointmentController::class, 'destroy'])->name('appointments.destroy');
        
        // Announcement Management
        Route::get('/announcements', [AdminAnnouncementController::class, 'index'])->name('announcements.index');
        Route::get('/announcements/create', [AdminAnnouncementController::class, 'create'])->name('announcements.create');
        Route::post('/announcements', [AdminAnnouncementController::class, 'store'])->name('announcements.store');
        Route::get('/announcements/{id}', [AdminAnnouncementController::class, 'show'])->name('announcements.show');
        Route::get('/announcements/{id}/edit', [AdminAnnouncementController::class, 'edit'])->name('announcements.edit');
        Route::put('/announcements/{id}', [AdminAnnouncementController::class, 'update'])->name('announcements.update');
        Route::delete('/announcements/{id}', [AdminAnnouncementController::class, 'destroy'])->name('announcements.destroy');

        Route::get('/ratings', [AdminController::class, 'manageRatings'])->name('ratings.index');
        Route::get('/ratings/{id}/edit', [AdminController::class, 'editRating'])->name('ratings.edit');
        Route::put('/ratings/{id}', [AdminController::class, 'updateRating'])->name('ratings.update');
        Route::delete('/ratings/{id}', [AdminController::class, 'deleteRating'])->name('ratings.destroy');
        
        Route::get('/lawyer-schedules', [\App\Http\Controllers\Admin\LawyerScheduleController::class,'index'])->name('lawyer.schedules');
        Route::get('/lawyer-schedules/lawyer/{lawyerId}', [\App\Http\Controllers\Admin\LawyerScheduleController::class,'getDates']);
        Route::get('/lawyer-schedules/{lawyerId}/{date}/slots', [\App\Http\Controllers\Admin\LawyerScheduleController::class,'getSlotsByLawyerDate']);
        Route::delete('/lawyer-schedules/delete/{id}', [\App\Http\Controllers\Admin\LawyerScheduleController::class,'deleteSlot']);
    });
    
    // Appointments Routes
    Route::get('/appointments/create/{lawyer_id}', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::put('/appointments/{id}/confirm', [AppointmentController::class, 'confirm'])->name('appointments.confirm');
    Route::put('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

    Route::post('/appointments/{appointment}/rate', [RatingController::class, 'store'])
        ->name('ratings.store')
        ->middleware('auth');
});
// Đánh dấu thông báo đã đọc + chuyển hướng
Route::get('/notifications/{id}/read', function ($id) {
    $notification = auth()->user()->notifications()->findOrFail($id);

    // TỰ ĐÁNH DẤU ĐÃ ĐỌC (vì bạn không dùng Laravel Notification)
    $notification->update([
        'is_read' => true,
        'read_at' => now(),
    ]);

    $url = $notification->data['url'] ?? route('appointments.index');

    return redirect($url);
})->name('notifications.read');
// Chat Routes
// routes/web.php – thêm vào cuối
Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/conversation/{user}', [ChatController::class, 'conversation'])->name('chat.conversation');
    Route::get('/chat/messages', [ChatController::class, 'userMessagesView'])->name('chat.messages');
    Route::get('/chat/conversations', [ChatController::class, 'conversationsJson'])->name('chat.conversations');
    Route::get('/chat/unread-count', [ChatController::class, 'unreadCount'])->name('chat.unread-count');
});