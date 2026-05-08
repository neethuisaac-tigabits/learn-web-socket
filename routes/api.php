<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChatRoomController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth (Sanctum tokens)
|--------------------------------------------------------------------------
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);

    /*
    |--------------------------------------------------------------------------
    | Chat
    |--------------------------------------------------------------------------
    */
    Route::get('/chat-rooms',          [ChatRoomController::class, 'index']);
    Route::post('/chat-rooms',         [ChatRoomController::class, 'store']);
    Route::get('/chat-rooms/{id}',     [ChatRoomController::class, 'show'])->whereNumber('id');
    Route::post('/chat-rooms/{id}/join', [ChatRoomController::class, 'join'])->whereNumber('id');

    Route::get('/chat-rooms/{id}/messages',  [MessageController::class, 'index'])->whereNumber('id');
    Route::post('/chat-rooms/{id}/messages', [MessageController::class, 'store'])->whereNumber('id');
    Route::post('/chat-rooms/{id}/typing',   [MessageController::class, 'typing'])->whereNumber('id');
});

/*
|--------------------------------------------------------------------------
| Pre-existing v1/orders routes (kept for backward compatibility)
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function () {
    Route::get('/orders',                    [OrderApiController::class, 'index']);
    Route::get('/orders/{id}',               [OrderApiController::class, 'show'])->whereNumber('id');
    Route::post('/orders/{id}/increment',    [OrderApiController::class, 'increment'])->whereNumber('id');
    Route::put('/orders/{id}',               [OrderController::class, 'update'])->where(['id' => '[0-9]+']);
});
