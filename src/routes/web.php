<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EcUserController;
use App\Http\Controllers\EcProductController;
use App\Http\Controllers\EcCartDetailController;
use Illuminate\Support\Facades\Route;

Route::prefix('ec_site')->group(function () {
    // ルートページ
    Route::get('/', [IndexController::class, 'index'])->name('ec_site.index');

    // 管理メニューページ
    Route::middleware('auth')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('ec_site.admin');
    });

    // ユーザー管理ページ
    Route::middleware('auth')->group(function () {
        Route::get('/admin/users', [EcUserController::class, 'index'])->name('users.index');
        Route::post('/admin/users/create', [EcUserController::class, 'store'])->name('users.store');
        Route::post('/admin/users/update', [EcUserController::class, 'update'])->name('users.update');
    });

    // 商品管理ページ
    Route::middleware('auth')->group(function () {
        Route::get('/admin/products', [EcProductController::class, 'index'])->name('products.index');
        Route::post('/admin/products/create', [EcProductController::class, 'store'])->name('products.store');
        Route::post('/admin/products/update', [EcProductController::class, 'update'])->name('products.update');
    });

    // 商品一覧ページ
    Route::middleware('auth')->group(function () {
        Route::get('/items', [ItemController::class, 'index'])->name('items.index');
        Route::post('/items', [ItemController::class, 'cart'])->name('items.cart');
    });

    // カートページ
    Route::middleware('auth')->group(function () {
        Route::get('/cart', [EcCartDetailController::class, 'list'])->name('cart.index');
    });

    //認証ページ
    require __DIR__ . '/auth.php';
});
