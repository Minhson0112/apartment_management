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
    Route::get('/apartment/search', [ApartmentController::class, 'search'])->name('apartment.search');
    // chi tiết căn hộ
    Route::get('/apartment/{id}', [ApartmentController::class, 'detail'])->name('apartment.detail');
    Route::get('/apartment/{id}/images', [ApartmentController::class, 'showImage'])->name('apartment.image');
    Route::get('/apartment/{id}/detail', [ApartmentController::class, 'showDetail'])->name('apartment.detail');
    Route::post('/apartment/add', [ApartmentController::class, 'store'])->name('apartment.store');

    //hiển thị trang quản lý chủ nhà
    Route::get('/owner', [OwnerController::class, 'showOwner'])->name('owner');
    Route::get('/owners/{cccd}/images', [OwnerController::class, 'showImage'])->name('owner.image');
    Route::post('/owner/add', [OwnerController::class, 'store'])->name('owner.store');
    Route::get('/owner/search', [OwnerController::class, 'search'])->name('owner.search');
    Route::post('/owners/{cccd}/images', [OwnerController::class, 'storeImages'])->name('owner.image.store');
    Route::delete('/owners/{cccd}/images/{imageId}', [OwnerController::class, 'deleteImage'])->name('owner.image.delete');
});
