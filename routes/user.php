<?php

use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\SocialiteController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified', 'suspended'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::middleware('auth')->prefix('settings')->group(function () {
    Route::redirect('/', 'settings/profile');

    Route::controller(ProfileController::class)->group(function () {
        Route::get('profile', 'edit')->name('profile.edit');
        Route::patch('profile', 'update')->name('profile.update');
        Route::delete('profile', 'destroy')->name('profile.destroy');
    });

    Route::controller(PasswordController::class)->group(function () {
        Route::get('password', 'edit')->name('password.edit');
        Route::put('password', 'update')->name('password.update');
    });

    Route::get('socialite', [SocialiteController::class, 'edit'])->name('socialite.edit');

    Route::get('appearance', function () {
        return Inertia::render('settings/appearance');
    })->name('appearance');
});

require __DIR__.'/user-auth.php';
