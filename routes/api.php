<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\QuestionController;
use \App\Http\Controllers\AnsweredQuestionController;

Route::group([
    'as' => 'questions.',
], function () {
    Route::get('questions', [QuestionController::class, 'index'])
        ->name('list');

    Route::group([
        'as' => 'answers.',
        'controller' => AnsweredQuestionController::class,
        'middleware' => ['auth:sanctum', 'verified']
    ], function () {
        Route::get('questions/answers', 'index')
            ->name('list');

        Route::post('questions/answers', 'store')
            ->name('store');

        Route::put('questions/answers/{answeredQuestion}', 'update')
            ->name('update');
    });
});
