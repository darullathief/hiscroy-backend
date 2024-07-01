<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\SeriesController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function () {
    Route::post('/auth/register', 'register');
    Route::post('/auth/login', 'login');
});

Route::controller(StoryController::class)->group(function () {
    Route::post('/story/create', 'create');
    Route::post('/story/delete', 'delete');
    Route::post('/story/update', 'update');
    Route::get('/story/get/{id?}', 'get_story');
    Route::get('/story/get_latest', 'get_latest_story');
});

Route::controller(SeriesController::class)->group(function () {
    Route::post('/series/create', 'create');
});
