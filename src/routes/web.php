<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EcUserController;
use App\Http\Controllers\EcProductController;
use App\Http\Controllers\EcCartDetailController;
use Illuminate\Support\Facades\Route;

Route::prefix('ec_site')->group(function () {
    // ルートページ
    Route::get('/', [IndexController::class, 'index'])->name('ec_site.index');

    // ユーザー管理ページ
    Route::middleware('auth')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    });

    // ユーザー管理ページ
    Route::middleware('auth')->group(function () {
        Route::get('/admin/users', [EcUserController::class, 'index'])->name('users.index');
        Route::post('/admin/users', [EcUserController::class, 'store'])->name('users.store');
        Route::patch('/admin/users', [EcUserController::class, 'update'])->name('users.update');
    });

    // 商品管理ページ
    Route::middleware('auth')->group(function () {
        Route::get('/admin/products', [EcProductController::class, 'index'])->name('products.index');
        Route::post('/admin/products', [EcProductController::class, 'store'])->name('products.store');
        Route::patch('/admin/products', [EcProductController::class, 'update'])->name('products.update');
    });

    // 商品一覧ページ
    Route::middleware('auth')->group(function () {
        Route::get('/list', [EcProductController::class, 'list'])->name('products.list');
    });

    // カートページ
    Route::middleware('auth')->group(function () {
        Route::get('/cart', [EcCartDetailController::class, 'list'])->name('cartdetails.index');
    });

    //認証ページ
    require __DIR__ . '/auth.php';
});
