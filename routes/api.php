<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiLoginController;
use App\Http\Controllers\OrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login', [ApiLoginController::class, 'authenticate']);
Route::middleware('auth:sanctum')->prefix('orders')->group(function() {
    Route::get('/', [OrderController::class, 'index']);
    Route::post('/', [OrderController::class, 'store']);
    Route::put('/{id}', [OrderController::class, 'update'])->where(['id' => '[0-9]+']);
    Route::get('/{id}', [OrderController::class, 'show'])->where(['id' => '[0-9]+']);
});
