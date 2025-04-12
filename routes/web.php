<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    // return Inertia::render('welcome');
    return to_route('dashboard');
})->name('home');


require __DIR__.'/user.php';
require __DIR__.'/admin.php';
