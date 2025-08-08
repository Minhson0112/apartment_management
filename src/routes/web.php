<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Main\ApartmentController;
use App\Http\Controllers\Main\DashBoardController;
use App\Http\Controllers\Main\OwnerController;
use Illuminate\Support\Facades\Route;

// Hiển thị form login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Xử lý POST login
Route::post('/login', [LoginController::class, 'login']);

// Route logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// cần đăng nhập
Route::middleware('auth')->group(function () {
    // hiển thị trang dashboard
    Route::get('/dashboard', [DashBoardController::class, 'showDashBoard'])->name('dashboard');

    // hiển thị trang các căn hộ
    Route::get('/apartment', [ApartmentController::class, 'showApartment'])->name('apartment');
    // chi tiết căn hộ
    Route::get('/apartment/{id}', [ApartmentController::class, 'detail'])->name('apartment.detail');

    //hiển thị trang quản lý chủ nhà
    Route::get('/owner', [OwnerController::class, 'showOwner'])->name('owner');
    Route::get('/owner/image', [OwnerController::class, 'showImage'])->name('owner.image');
    Route::post('/owner', [OwnerController::class, 'store'])->name('owner.store');
});
