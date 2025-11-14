<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Lawyer\LawyerController;

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

// Dashboard Routes (temporary - will be implemented later)
Route::get('/admin/dashboard', function() {
    return 'Admin Dashboard';
})->name('admin.dashboard');

Route::get('/lawyer/dashboard', function() {
    return 'Lawyer Dashboard';
})->name('lawyer.dashboard');

Route::get('/customer/dashboard', function() {
    return 'Customer Dashboard';
})->name('customer.dashboard');
