<?php

use App\Http\Controllers\Admin\Settings\PasswordController;
use App\Http\Controllers\Admin\Settings\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth:admin', 'admin.suspended'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', fn() => Inertia::render('admin/dashboard'))->name('dashboard');

    Route::redirect('settings', 'settings/profile');

    Route::prefix('settings')->group(function () {
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('password', [PasswordController::class, 'edit'])->name('password.edit');
        Route::put('password', [PasswordController::class, 'update'])->name('password.update');

        Route::get('appearance', fn() => Inertia::render('admin/settings/appearance'))->name('appearance');
    });
});

require __DIR__.'/admin-auth.php';