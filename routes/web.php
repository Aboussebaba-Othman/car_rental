<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\DashboardController;

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/register/company', [RegisterController::class, 'showCompanyRegisterForm'])->name('register.company');
    Route::post('/register/company', [RegisterController::class, 'registerCompany']);

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');
});

Route::get('/auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback']);

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/auth/account-type', [App\Http\Controllers\Auth\AccountTypeController::class, 'showTypeSelection'])->name('auth.account.type');
Route::post('/auth/account-type', [App\Http\Controllers\Auth\AccountTypeController::class, 'processTypeSelection'])->name('auth.account.type.process');

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

    Route::prefix('company')->group(function () {
        Route::get('/reservations', [App\Http\Controllers\Company\ReservationController::class, 'index'])->name('company.reservations.index');
        Route::get('/reservations/export', [App\Http\Controllers\Company\ReservationController::class, 'export'])->name('company.reservations.export');
        Route::get('/reservations/{reservation}', [App\Http\Controllers\Company\ReservationController::class, 'show'])->name('company.reservations.show');
        Route::post('/reservations/{reservation}/confirm', [App\Http\Controllers\Company\ReservationController::class, 'confirm'])->name('company.reservations.confirm');
        Route::post('/reservations/{reservation}/cancel', [App\Http\Controllers\Company\ReservationController::class, 'cancel'])->name('company.reservations.cancel');
        Route::post('/reservations/{reservation}/complete', [App\Http\Controllers\Company\ReservationController::class, 'complete'])->name('company.reservations.complete');
        Route::post('/reservations/{reservation}/mark-paid', [App\Http\Controllers\Company\ReservationController::class, 'markPaid'])->name('company.reservations.mark-paid');
        Route::post('/reservations/{reservation}/add-note', [App\Http\Controllers\Company\ReservationController::class, 'addNote'])->name('company.reservations.add-note');
        Route::get('/reservations/{reservation}/invoice', [App\Http\Controllers\Company\ReservationController::class, 'generateInvoice'])->name('company.reservations.invoice');
        Route::post('/reservations/{reservation}/send-payment-reminder', [App\Http\Controllers\Company\ReservationController::class, 'sendPaymentReminder'])->name('company.reservations.send-payment-reminder');

        Route::post('/invoices/{id}/download', [App\Http\Controllers\Company\InvoiceController::class, 'download'])->name('company.invoices.download');

        // Route::get('/customers', [App\Http\Controllers\Company\CustomerController::class, 'index'])->name('company.customers.index');
        // Route::get('/customers/{user}', [App\Http\Controllers\Company\CustomerController::class, 'show'])->name('company.customers.show');
        // Route::post('/customers/{user}/send-promotion', [App\Http\Controllers\Company\CustomerController::class, 'sendPromotion'])->name('company.customers.send-promotion');
        // Route::get('/customers/{user}/report', [App\Http\Controllers\Company\CustomerController::class, 'generateReport'])->name('company.customers.report');
    });
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/companies', [App\Http\Controllers\Admin\CompanyManagementController::class, 'index'])->name('companies.index');
    Route::post('/companies/{id}/validate', [App\Http\Controllers\Admin\CompanyManagementController::class, 'validate'])->name('companies.validate');
    Route::post('/companies/{id}/suspend', [App\Http\Controllers\Admin\CompanyManagementController::class, 'suspend'])->name('companies.suspend');
    Route::post('/companies/{id}/reactivate', [App\Http\Controllers\Admin\CompanyManagementController::class, 'reactivate'])->name('companies.reactivate');
    Route::get('/companies/filter', [App\Http\Controllers\Admin\CompanyManagementController::class, 'filter'])->name('companies.filter');
    Route::get('/companies/{id}', [App\Http\Controllers\Admin\CompanyManagementController::class, 'show'])->name('companies.show');

    Route::get('/vehicles', [App\Http\Controllers\Admin\VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/vehicles/{id}', [App\Http\Controllers\Admin\VehicleController::class, 'show'])->name('vehicles.show');
    
    Route::get('/reservations', [App\Http\Controllers\Admin\ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/{id}', [App\Http\Controllers\Admin\ReservationController::class, 'show'])->name('reservations.show');
    
    Route::get('/users', [App\Http\Controllers\Admin\UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'show'])->name('users.show');
    Route::post('/users/{id}/activate', [App\Http\Controllers\Admin\UserManagementController::class, 'activate'])->name('users.activate');
    Route::post('/users/{id}/deactivate', [App\Http\Controllers\Admin\UserManagementController::class, 'deactivate'])->name('users.deactivate');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/reservations', [App\Http\Controllers\ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create/{vehicleId}', [App\Http\Controllers\ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [App\Http\Controllers\ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{reservation}', [App\Http\Controllers\ReservationController::class, 'show'])->name('reservations.show');
    Route::get('/reservations/{reservation}/payment', [App\Http\Controllers\ReservationController::class, 'payment'])->name('reservations.payment');
    Route::post('/reservations/{reservation}/cancel', [App\Http\Controllers\ReservationController::class, 'cancel'])->name('reservations.cancel');
    
    Route::post('/reservations/{reservation}/paypal', [App\Http\Controllers\ReservationController::class, 'processPayPal'])->name('reservations.paypal.process');
    Route::get('/reservations/{reservation}/paypal/success', [App\Http\Controllers\ReservationController::class, 'paypalSuccess'])->name('reservations.paypal.success');
    Route::get('/reservations/{reservation}/paypal/cancel', [App\Http\Controllers\ReservationController::class, 'paypalCancel'])->name('reservations.paypal.cancel');
    Route::get('/reservations/{reservation}/payment/confirmation', [App\Http\Controllers\ReservationController::class, 'paymentConfirmation'])->name('reservations.payment.confirmation');
});

Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('home');
Route::get('/vehicles', [App\Http\Controllers\VehicleController::class, 'index'])->name('vehicles.index');
Route::get('/vehicles/{id}', [App\Http\Controllers\VehicleController::class, 'show'])->name('vehicles.show');
Route::get('/location-search', [App\Http\Controllers\LocationSearchController::class, 'search'])->name('location.search');