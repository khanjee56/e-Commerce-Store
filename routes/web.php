<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AdminController;

// Home page
Route::get('/', [HomeController::class, 'index']);

// Custom Auth (Login/Register/Logout)
Route::get('/register',[HomeController::class, 'register'])->name('register');
Route::post('/register',[HomeController::class, 'registersave'])->name('register.save');
Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::post('/login', [HomeController::class, 'loginsave'])->name('login.save');
Route::post('/logout',[HomeController::class, 'logout'])->name('logout');

// Forgot Password Routes (Manual - Auth::routes() is broken in Laravel 12)
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Products
Route::get('/products/{id}', [ProductController::class, 'show']);

// Logged-in user routes
Route::middleware('auth')->group(function() {
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::delete('/cart/remove', [CartController::class, 'remove']);
    Route::get('/cart/clear', [CartController::class, 'clear']);
    Route::get('/orders/place', [OrderController::class, 'placeOrderPage']);
    Route::post('/orders/place', [OrderController::class, 'placeOrder']);
    Route::get('/orders', [OrderController::class, 'myOrders']);
});


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function() {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::post('/logout', [AdminController::class, 'logout']);

    Route::get('/products', [AdminController::class, 'products']);
    Route::get('/products/create', [AdminController::class, 'createProduct']);
    Route::post('/products', [AdminController::class, 'storeProduct']);
    Route::get('/products/{id}/edit', [AdminController::class, 'editProduct']);
    Route::put('/products/{id}', [AdminController::class, 'updateProduct']);
    Route::delete('/products/{id}', [AdminController::class, 'destroyProduct']);
    Route::get('/categories', [AdminController::class, 'categories']);
Route::get('/categories/create', [AdminController::class, 'createCategory']);
Route::post('/categories', [AdminController::class, 'storeCategory']);
Route::get('/categories/{id}/edit', [AdminController::class, 'editCategory']);
Route::put('/categories/{id}', [AdminController::class, 'updateCategory']);
Route::delete('/categories/{id}', [AdminController::class, 'destroyCategory']);
Route::get('/orders', [AdminController::class, 'orders']);
Route::put('/orders/{id}', [AdminController::class, 'updateOrderStatus']);
Route::get('/allusers', [AdminCOntroller::class, 'show']);
Route::get('/delete/{id}', [AdminController::class, 'delete']);
// Face Login Routes

 Route::get('/face-setup', [AdminController::class, 'faceSetup']);
    Route::post('/save-face', [AdminController::class, 'saveFace']);



});
Route::get('/face-login', [HomeController::class, 'faceLogin'])->name('face.login');
Route::post('/face-login-verify', [HomeController::class, 'faceLoginVerify']);