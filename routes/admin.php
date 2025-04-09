<?php

use App\Http\Controllers\Admin\Settings\PasswordController;
use App\Http\Controllers\Admin\Settings\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth:admin', 'admin.suspended'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', fn() => Inertia::render('admin/dashboard'))->name('dashboard');

    Route::redirect('settings', 'settings/profile');

    Route::prefix('settings')->group(function () {
        Route::controller(ProfileController::class)->group(function () {
            Route::get('profile', 'edit')->name('profile.edit');
            Route::patch('profile', 'update')->name('profile.update');
            Route::delete('profile', 'destroy')->name('profile.destroy');
        });

        Route::controller(PasswordController::class)->group(function () {
            Route::get('password', 'edit')->name('password.edit');
            Route::put('password', 'update')->name('password.update');
        });

        Route::get('appearance', fn() => Inertia::render('admin/settings/appearance'))->name('appearance');
    });

    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
});

require __DIR__.'/admin-auth.php';