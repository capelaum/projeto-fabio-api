<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\QuestionController;

Route::group([
    'as' => 'questions.',
], function () {
    Route::get('questions', [QuestionController::class, 'index'])
        ->name('list');
});
