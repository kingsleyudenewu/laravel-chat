<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
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
    'prefix' => 'messages',
    'as' => 'messages.',
    'middleware' => 'auth:sanctum',
], function () {
    Route::get('/', [MessageController::class, 'getMessages'])->name('get');
    Route::post('/', [MessageController::class, 'sendMessage'])->name('send');
});
