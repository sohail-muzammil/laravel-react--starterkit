<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'admin.suspended'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/admin-auth.php';