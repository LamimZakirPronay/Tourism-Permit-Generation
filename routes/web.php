<?php

use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TourGuideController;
use App\Http\Controllers\Admin\TwoFactorController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TourismPermitController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [TourismPermitController::class, 'create'])->name('permit.create');
Route::post('/permit', [TourismPermitController::class, 'store'])->name('permit.store');

// Success page after submission
Route::get('/permit/success/{permit}', [TourismPermitController::class, 'success'])
    ->name('permit.success');

// Verification route (Public QR Scan)
Route::get('/permit/verify/{id}', [TourismPermitController::class, 'verify'])
    ->name('permit.verify');

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

    // --- 2FA Setup & Verification ---
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
        Route::resource('areas', AreaController::class);

        // --- Permit Management ---
        Route::get('permit/index', [TourismPermitController::class, 'index'])->name('permit.index');
        Route::get('permit/closing-panel', [TourismPermitController::class, 'closingPanel'])->name('permit.closing-panel');
        Route::get('permit/export', [TourismPermitController::class, 'exportAll'])->name('permit.export.all');

        // Permit Actions
        Route::group(['prefix' => 'permit/{permit}'], function () {
            Route::get('/', [TourismPermitController::class, 'show'])->name('permit.show');
            Route::get('/edit', [TourismPermitController::class, 'edit'])->name('permit.edit');
            Route::put('/', [TourismPermitController::class, 'update'])->name('permit.update');

            // PDF Downloads
            Route::get('/download', [TourismPermitController::class, 'downloadPDF'])->name('permit.download');

            // NEW: Token PDF Download (Thermal 80mm)
            Route::get('/tokens-download', [TourismPermitController::class, 'exportIndividualTokensPdf'])->name('permit.tokens.download');

            // Status Actions
            Route::patch('/status-update', [TourismPermitController::class, 'updateStatus'])->name('permit.update-status');
            Route::patch('/exit', [TourismPermitController::class, 'markAsExited'])->name('permit.exit');
        });

        // Site Settings
        Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    });
});
