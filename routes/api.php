<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TopicController;
use App\Http\Controllers\Api\AnswerController;

Route::resource('categories', CategoryController::class)
    ->only(['index', 'show']);

Route::resource('topics', TopicController::class);
Route::resource('answers', AnswerController::class);