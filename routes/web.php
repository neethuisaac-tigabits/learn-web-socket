<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    // return view('welcome');
    return view('home');
});
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/update', [OrderController::class, 'update']);