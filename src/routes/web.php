<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompleteController;
use App\Http\Controllers\EcUserController;
use App\Http\Controllers\EcProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('ec_site')->group(function () {
    // ルートページ
    Route::get('/', [IndexController::class, 'index'])->name('ec_site.index');

    // 管理者
    Route::middleware([\App\Http\Middleware\CheckAdmin::class])->group(function () {
        // 管理メニューページ
        Route::get('admin', [AdminController::class, 'index'])->name('ec_site.admin');

        // ユーザー管理ページ
        Route::get('admin/users', [EcUserController::class, 'index'])->name('users.index');
        Route::post('admin/users/store', [EcUserController::class, 'store'])->name('users.store');
        Route::post('admin/users/update', [EcUserController::class, 'update'])->name('users.update');

        // 商品管理ページ
        Route::get('admin/products', [EcProductController::class, 'index'])->name('products.index');
        Route::post('admin/products/store', [EcProductController::class, 'store'])->name('products.store');
        Route::post('admin/products/update', [EcProductController::class, 'update'])->name('products.update');
    });

    // 利用者
    Route::middleware([\App\Http\Middleware\CheckNormal::class])->group(function () {
        // 商品一覧ページ
        Route::get('items', [ItemController::class, 'index'])->name('items.index');
        Route::post('items/store', [ItemController::class, 'store'])->name('items.store');

        // カートページ
        Route::get('cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('cart/update', [CartController::class, 'update'])->name('cart.update');
        Route::post('cart/delete', [CartController::class, 'delete'])->name('cart.delete');
        Route::post('cart/clear', [CartController::class, 'clear'])->name('cart.clear');
        Route::post('cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

        // 決済完了ページ
        Route::get('complete', [CompleteController::class, 'index'])->name('complete.index');
    });

    //認証ページ
    require __DIR__ . '/auth.php';
});
