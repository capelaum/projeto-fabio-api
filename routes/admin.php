<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DisciplineController;


Route::group([
    'as' => 'admin.',
], function () {
    Route::apiResource('questions', QuestionController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('disciplines', DisciplineController::class);
});
