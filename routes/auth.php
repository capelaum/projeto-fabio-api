<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'auth.',
    'controller' => AuthController::class
], function () {
    Route::post('register', 'register')
        ->name('register');

    Route::post('login', 'login')
        ->name('login');

    Route::group([
        'middleware' => ['auth:sanctum', 'verified']
    ], function () {
        Route::get('me', 'getAuthUser')
            ->name('user');

        Route::post('logout', 'logout')
            ->name('logout');
    });
});

Route::group([
    'as' => 'verification.',
    'prefix' => 'email/verify',
    'middleware' => 'throttle:6,1',
    'controller' => VerifyEmailController::class
], function () {
    Route::get('{id}/{hash}', 'verify')
        ->middleware(['signed'])
        ->name('verify');

    Route::post('resend', 'send')
        ->middleware(['auth:sanctum'])
        ->name('send');
});

Route::group([
    'as' => 'password.',
    'prefix' => 'password',
    'middleware' => 'throttle:6,1',
    'controller' => ResetPasswordController::class
], function () {
    Route::post('forgot', 'email')
        ->name('email');

    Route::get('reset/{token}', 'reset')
        ->name('reset');

    Route::post('reset', 'update')
        ->name('update');
});
