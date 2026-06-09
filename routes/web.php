<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::get('/welcome', [App\Http\Controllers\CategoryController::class ,'index']);

