<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    // return view('welcome');
    return view('home');
});
Route::group([
    'prefix' => 'orders'
], function() {
    Route::get('/', [OrderController::class, 'index']);
    Route::post('/', [OrderController::class, 'store']);
    Route::get('/create', fn() => view('orders.create'));
    Route::get('/update/{id}', [OrderController::class, 'update'])->where(['id' => '[0-9]+'])->middleware('auth');
    Route::get('/{id}', [OrderController::class, 'show'])->where(['id' => '[0-9]+'])->middleware('auth');
});

Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/logout', [LoginController::class, 'destroy']);
Route::get('/dashboard', fn() => 'dashboard')->middleware('auth');