<?php

use App\Http\Controllers\Auth\UserSocialController;
use Illuminate\Support\Facades\Route;

Route::controller(UserSocialController::class)->middleware('web')->prefix('auth')->as('auth.socialite.')->group(function () {
    Route::get('redirect/{provider}', 'redirect')->name('redirect');
    Route::get('callback/{provider}',  'callback')->name('callback');
    Route::delete('disconnect/{driver}', 'disconnect')->name('disconnect');
});