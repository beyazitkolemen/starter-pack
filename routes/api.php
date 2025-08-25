<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\UserProfileController;
use App\Http\Controllers\Api\Blog\ListBlogsController;
use App\Http\Controllers\Api\Blog\GetBlogController;

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

Route::prefix('blogs')->group(function () {

 // Blog Routes - 2 temel endpoint
 Route::get('/', ListBlogsController::class);            // LIST
 Route::get('/{slug}', GetBlogController::class);       // SINGLE (slug ile)
});
