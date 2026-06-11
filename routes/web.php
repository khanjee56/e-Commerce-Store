<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;



Auth::routes();

Route::get('/', [HomeController::class, 'index']);
Route::get('/register',[HomeController::class, 'register'])->name('register');
Route::post('/register',[HomeController::class, 'registersave'])->name('register.save');
Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::post('/login', [HomeController::class, 'loginsave'])->name('login.save');
Route::post('/logout',[HomeController::class, 'logout'])->name('logout');
Route::get('/products/{id}', [ProductController::class, 'show']);


Route::middleware('auth')->group(function() {
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::delete('/cart/remove', [CartController::class, 'remove']);
    Route::get('/cart/clear', [CartController::class, 'clear']);
     Route::get('/orders/place', [OrderController::class, 'placeOrderPage']);
    Route::post('/orders/place', [OrderController::class, 'placeOrder']);
    Route::get('/orders', [OrderController::class, 'myOrders']);
});
