<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Hiển thị form
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Xử lý POST login
Route::post('/login', [LoginController::class, 'login']);

// Route logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
