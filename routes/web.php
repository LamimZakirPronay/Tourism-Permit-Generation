<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourismPermitController;
use App\Http\Controllers\Admin\TourGuideController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TwoFactorController;
use App\Http\Controllers\Admin\AreaController;

/*
|--------------------------------------------------------------------------
| 1. Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [TourismPermitController::class, 'create'])->name('permit.create');
Route::post('/permit', [TourismPermitController::class, 'store'])->name('permit.store');

// UUID verification route (Public)
Route::get('/permit/verify/{permit}', [TourismPermitController::class, 'verify'])
    ->name('permit.verify')
    ->whereUuid('permit'); 

/*
|--------------------------------------------------------------------------
| 2. Authentication
|--------------------------------------------------------------------------
*/
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| 3. Admin Routes (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // --- 2FA Setup & Verification (Required before accessing dashboard) ---
    Route::get('/2fa/setup', [TwoFactorController::class, 'setup'])->name('2fa.setup');
    Route::get('/2fa/challenge', [TwoFactorController::class, 'challenge'])->name('2fa.challenge');
    Route::post('/2fa/verify', [TwoFactorController::class, 'verify'])->name('2fa.verify');

    // --- Fully Protected Routes (Require Auth + 2FA) ---
    Route::middleware(['2fa'])->group(function () {
        
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // User / Officer Management
        Route::resource('users', UserController::class);
        Route::post('users/{user}/reset-2fa', [UserController::class, 'reset2fa'])->name('users.reset2fa');

        // Tour Guide, Driver, and Area Management
        Route::resource('guides', TourGuideController::class);
        Route::resource('drivers', DriverController::class);
        Route::resource('areas', AreaController::class); // Added here correctly

        // --- Permit Management ---
        Route::get('permit', [TourismPermitController::class, 'index'])->name('permit.index');
        
        // Export Route
        Route::get('permit/export', [TourismPermitController::class, 'exportAll'])->name('permit.export.all');

        // Specialized Panels
        Route::get('permit/closing-panel', [TourismPermitController::class, 'closingPanel'])->name('permit.closing-panel');

        // Resource actions with UUID constraints
        Route::get('permit/{permit}', [TourismPermitController::class, 'show'])->name('permit.show')->whereUuid('permit');
        Route::get('permit/{permit}/edit', [TourismPermitController::class, 'edit'])->name('permit.edit')->whereUuid('permit');
        Route::put('permit/{permit}', [TourismPermitController::class, 'update'])->name('permit.update')->whereUuid('permit');
        
        // Custom Patch Actions
        Route::patch('permit/{permit}/exit', [TourismPermitController::class, 'markAsExited'])->name('permit.exit')->whereUuid('permit');
        Route::patch('permit/{permit}/close', [TourismPermitController::class, 'closePermit'])->name('permit.close')->whereUuid('permit');

        // Site Settings
        Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    });
});