<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;



Auth::routes();

Route::get('/', [HomeController::class, 'index']);
Route::get('/register',[HomeController::class, 'register'])->name('register');
Route::post('/register',[HomeController::class, 'registersave'])->name('register.save');
Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::post('/login', [HomeController::class, 'loginsave'])->name('login.save');
Route::post('/logout',[HomeController::class, 'logout'])->name('logout');

