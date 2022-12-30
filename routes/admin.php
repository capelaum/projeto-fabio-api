<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DisciplineController;
use App\Http\Controllers\Admin\SubjectController;
use \App\Http\Controllers\Admin\UserController;


Route::group([
    'as' => 'admin.',
], function () {
    Route::get('questions/years', [QuestionController::class, 'years'])
        ->name('questions.years');

    Route::apiResource('questions', QuestionController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('disciplines', DisciplineController::class);
    Route::apiResource('subjects', SubjectController::class);

    Route::group([
        'as' => 'users'
    ], function () {
        Route::get('users', [UserController::class, 'index'])
            ->name('.list');

        Route::get('users/{user}/answers', [UserController::class, 'answers'])
            ->name('answers');
    });
});
