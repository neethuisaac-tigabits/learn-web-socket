<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    // return view('welcome');
    return view('home');
});
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/update/{id}', [OrderController::class, 'update'])->where(['id' => '[0-9]+'])->middleware('auth');
Route::get('/orders/{id}', [OrderController::class, 'show'])->where(['id' => '[0-9]+'])->middleware('auth');
Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/dashboard', fn() => 'dashboard')->middleware('auth');