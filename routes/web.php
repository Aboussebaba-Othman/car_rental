<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Authentication Routes
Route::middleware('guest')->group(function () {
    // Registration Routes
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/register/company', [RegisterController::class, 'showCompanyRegisterForm'])->name('register.company');
    Route::post('/register/company', [RegisterController::class, 'registerCompany']);

    // Login Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Password Reset Routes
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');
});

// Logout Route
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout')->middleware('auth');

// Role-based Routes
// Route::middleware(['auth', 'role:user'])->group(function () {
//     Route::get('/profile', [UserController::class, 'showProfile'])->name('user.profile');
//     // Add more user routes here
// });

// Route::middleware(['auth', 'role:company'])->group(function () {
//     Route::get('/company/dashboard', [CompanyController::class, 'dashboard'])->name('company.dashboard');
//     // Add more company routes here
// });

// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
//     // Add more admin routes here
// });

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');