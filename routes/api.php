<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TopicController;
use App\Http\Controllers\Api\AnswerController;

Route::resource('categories', CategoryController::class)
    ->only(['index', 'show']);

Route::resource('topics', TopicController::class);
Route::post('/topics/{topic}/vote', [TopicController::class, 'vote'])->name('topics.vote');
Route::resource('topics.answers', AnswerController::class);
Route::post('/answers/{answer}/vote', [AnswerController::class, 'vote'])->name('answers.vote');
