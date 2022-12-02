<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\CategoryController;


Route::group([
    'as' => 'admin.',
], function () {

    Route::apiResource('questions', QuestionController::class);
    Route::apiResource('categories', CategoryController::class);
});
