<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\UserProfileController;

// Test endpoint
Route::get('/test', TestController::class);

// Authentication Routes
Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', LogoutController::class);
    Route::get('/user', UserProfileController::class);
});
