<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\DashboardController;

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
// Google login
Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);

// Logout Route
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/auth/account-type', [App\Http\Controllers\Auth\AccountTypeController::class, 'showTypeSelection'])->name('auth.account.type');
Route::post('/auth/account-type', [App\Http\Controllers\Auth\AccountTypeController::class, 'processTypeSelection'])->name('auth.account.type.process');


// Role-based Routes
// Route::middleware(['auth', 'role:user'])->group(function () {
//     Route::get('/profile', [UserController::class, 'showProfile'])->name('user.profile');
//     // Add more user routes here
// });

// Company document routes
Route::middleware(['auth', 'role:company'])->group(function () {
    Route::get('/company/dashboard', 'App\Http\Controllers\Company\DashboardController@index')->name('company.dashboard');
    Route::get('/company/documents/upload', [App\Http\Controllers\Company\DocumentController::class, 'showUploadForm'])->name('company.documents.upload');
    Route::post('/company/documents/upload', [App\Http\Controllers\Company\DocumentController::class, 'uploadDocuments'])->name('company.documents.store');
    Route::get('/company/complete-registration', [App\Http\Controllers\Company\RegistrationController::class, 'showCompleteRegistration'])->name('company.complete-registration');
    Route::post('/company/complete-registration', [App\Http\Controllers\Company\RegistrationController::class, 'completeRegistration'])->name('company.complete-registration.process');
    Route::get('/company/vehicles', 'App\Http\Controllers\Company\VehicleController@index')->name('company.vehicles.index');
    Route::get('/company/vehicles/create', 'App\Http\Controllers\Company\VehicleController@create')->name('company.vehicles.create');
    Route::post('/company/vehicles', 'App\Http\Controllers\Company\VehicleController@store')->name('company.vehicles.store');
    
    Route::get('/company/vehicles/{vehicle}', 'App\Http\Controllers\Company\VehicleController@show')->name('company.vehicles.show');
    Route::get('/company/vehicles/{vehicle}/edit', 'App\Http\Controllers\Company\VehicleController@edit')->name('company.vehicles.edit');
    Route::put('/company/vehicles/{vehicle}', 'App\Http\Controllers\Company\VehicleController@update')->name('company.vehicles.update');
    Route::delete('/company/vehicles/{vehicle}', 'App\Http\Controllers\Company\VehicleController@destroy')->name('company.vehicles.destroy');
    Route::patch('/company/vehicles/{vehicle}/toggle-active', 'App\Http\Controllers\Company\VehicleController@toggleActive')->name('company.vehicles.toggle-active');
    Route::patch('/company/vehicles/{vehicle}/toggle-availability', 'App\Http\Controllers\Company\VehicleController@toggleAvailability')->name('company.vehicles.toggle-availability');

    Route::get('/company/promotions', 'App\Http\Controllers\Company\PromotionController@index')->name('company.promotions.index');
    Route::get('/company/promotions/create', 'App\Http\Controllers\Company\PromotionController@create')->name('company.promotions.create');
    Route::post('/company/promotions', 'App\Http\Controllers\Company\PromotionController@store')->name('company.promotions.store');
    Route::get('/company/promotions/{promotion}', 'App\Http\Controllers\Company\PromotionController@show')->name('company.promotions.show');
    Route::get('/company/promotions/{promotion}/edit', 'App\Http\Controllers\Company\PromotionController@edit')->name('company.promotions.edit');
    Route::put('/company/promotions/{promotion}', 'App\Http\Controllers\Company\PromotionController@update')->name('company.promotions.update');
    Route::delete('/company/promotions/{promotion}', 'App\Http\Controllers\Company\PromotionController@destroy')->name('company.promotions.destroy');
    Route::patch('/company/promotions/{promotion}/toggle-active', 'App\Http\Controllers\Company\PromotionController@toggleActive')->name('company.promotions.toggle-active');
});

// Route::middleware(['auth', 'role:admin'])->group(function () {
//     // Add more admin routes here
// });
// Admin - Company Management Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/companies', [App\Http\Controllers\Admin\CompanyManagementController::class, 'index'])->name('companies.index');
    // Route::get('/companies/{id}', [App\Http\Controllers\Admin\CompanyManagementController::class, 'show'])->name('companies.show');
    Route::post('/companies/{id}/validate', [App\Http\Controllers\Admin\CompanyManagementController::class, 'validate'])->name('companies.validate');
    Route::post('/companies/{id}/suspend', [App\Http\Controllers\Admin\CompanyManagementController::class, 'suspend'])->name('companies.suspend');
    Route::post('/companies/{id}/reactivate', [App\Http\Controllers\Admin\CompanyManagementController::class, 'reactivate'])->name('companies.reactivate');
    Route::get('/companies/filter', [App\Http\Controllers\Admin\CompanyManagementController::class, 'filter'])->name('companies.filter');
    Route::get('/companies/{id}', [App\Http\Controllers\Admin\CompanyManagementController::class, 'show'])->name('companies.show');

    

    Route::get('/users', [App\Http\Controllers\Admin\UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'show'])->name('users.show');
    Route::post('/users/{id}/activate', [App\Http\Controllers\Admin\UserManagementController::class, 'activate'])->name('users.activate');
    Route::post('/users/{id}/deactivate', [App\Http\Controllers\Admin\UserManagementController::class, 'deactivate'])->name('users.deactivate');
});

// Reservation Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/reservations', [App\Http\Controllers\ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create/{vehicleId}', [App\Http\Controllers\ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [App\Http\Controllers\ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{reservation}', [App\Http\Controllers\ReservationController::class, 'show'])->name('reservations.show');
    Route::get('/reservations/{reservation}/payment', [App\Http\Controllers\ReservationController::class, 'payment'])->name('reservations.payment');
    Route::post('/reservations/{reservation}/cancel', [App\Http\Controllers\ReservationController::class, 'cancel'])->name('reservations.cancel');
    
    // PayPal Routes
    Route::post('/reservations/{reservation}/paypal', [App\Http\Controllers\ReservationController::class, 'processPayPal'])->name('reservations.paypal.process');
    Route::get('/reservations/{reservation}/paypal/success', [App\Http\Controllers\ReservationController::class, 'paypalSuccess'])->name('reservations.paypal.success');
    Route::get('/reservations/{reservation}/paypal/cancel', [App\Http\Controllers\ReservationController::class, 'paypalCancel'])->name('reservations.paypal.cancel');
});

// Public Routes
Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('home');
Route::get('/vehicles', [App\Http\Controllers\VehicleController::class, 'index'])->name('vehicles.index');
Route::get('/vehicles/{id}', [App\Http\Controllers\VehicleController::class, 'show'])->name('vehicles.show');