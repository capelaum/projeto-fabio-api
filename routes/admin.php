<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\QuestionController;


Route::group([
    'as' => 'admin.',
], function () {

    Route::apiResource('questions', QuestionController::class);
});
