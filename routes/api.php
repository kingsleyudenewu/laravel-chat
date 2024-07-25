<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'prefix' => 'auth',
    'as' => 'auth.',
], function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
});

Route::group([
    'prefix' => 'user',
    'as' => 'user.',
    'middleware' => 'auth:sanctum',
], function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/update', [AuthController::class, 'update'])->name('update');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
});
