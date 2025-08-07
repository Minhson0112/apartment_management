<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Main\ApartmentController;
use App\Http\Controllers\Main\DashBoardController;
use Illuminate\Support\Facades\Route;

// Hiển thị form
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Xử lý POST login
Route::post('/login', [LoginController::class, 'login']);

// Route logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// cần đăng nhập
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashBoardController::class, 'showDashBoard'])->name('dashboard');

    Route::get('/apartment', [ApartmentController::class, 'showApartment'])->name('apartment');
});
