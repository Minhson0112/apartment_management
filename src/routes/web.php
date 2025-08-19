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

// trang qảng cáo căn hộ
Route::get('/apartment/{id}/info', [ApartmentController::class, 'info'])->name('apartment.info');


// cần đăng nhập
Route::middleware('auth')->group(function () {
    // hiển thị trang dashboard
    Route::controller(DashBoardController::class)->group(function () {
        Route::get('/dashboard', 'showDashBoard')->name('dashboard');
    });

    // hiển thị trang các căn hộ
    Route::controller(ApartmentController::class)->group(function () {
        Route::get('/apartment', 'showApartment')->name('apartment');
        Route::get('/apartment/search', 'search')->name('apartment.search');
        Route::get('/apartment/{id}/images', 'showImage')->name('apartment.image');
        Route::get('/apartment/{id}/detail', 'detail')->name('apartment.detail');
        Route::post('/apartment/add', 'store')->name('apartment.store');
        Route::delete('/apartments/{id}/images/{imageId}', 'deleteImage')->name('apartment.image.delete');
        Route::post('/apartments/{id}/images', 'storeImages')->name('apartment.image.store');
        Route::put('/apartment/{id}', 'update')->name('apartment.update');
    });

    //hiển thị trang quản lý chủ nhà
    Route::controller(OwnerController::class)->group(function () {
        Route::get('/owner', 'showOwner')->name('owner');
        Route::get('/owners/{cccd}/images', 'showImage')->name('owner.image');
        Route::post('/owner/add', 'store')->name('owner.store');
        Route::get('/owner/search', 'search')->name('owner.search');
        Route::post('/owners/{cccd}/images', 'storeImages')->name('owner.image.store');
        Route::delete('/owners/{cccd}/images/{imageId}', 'deleteImage')->name('owner.image.delete');
    });
});
