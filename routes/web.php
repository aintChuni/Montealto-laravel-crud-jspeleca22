<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;

use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\ImageController;

use App\Http\Controllers\AuthController;

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('products', ProductController::class);
    Route::resource('images', ImageController::class);
    Route::post('/upload-image', [ImageUploadController::class, 'store'])->name('image.upload');
});

Route::get('/', function () {
 return redirect(route('products.index')); 
});