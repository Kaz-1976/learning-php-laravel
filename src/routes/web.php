<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompleteController;
use App\Http\Controllers\EcUserController;
use App\Http\Controllers\EcProductController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\MyReceiptController;
use App\Http\Controllers\MyAddressController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\ConfirmController;
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
        // マイページ
        Route::get('mypage', [MyPageController::class, 'index'])->name('mypage.index');

        // 個人情報ページ
        Route::get('mypage/profile', [MyProfileController::class, 'index'])->name('profile.index');

        // 宛先情報ページ
        Route::get('mypage/address', [MyAddressController::class, 'index'])->name('address.index');
        Route::post('mypage/address/search', [MyAddressController::class, 'search'])->name('address.search');
        Route::post('mypage/address/store', [MyAddressController::class, 'store'])->name('address.store');
        Route::post('mypage/address/update', [MyAddressController::class, 'update'])->name('address.update');

        // 購入履歴ページ
        Route::get('mypage/receipt', [MyReceiptController::class, 'index'])->name('receipt.index');
        Route::get('mypage/receipt/{id}', [MyReceiptController::class, 'show'])->name('receipt.show');

        // 商品一覧ページ
        Route::get('items', [ItemController::class, 'index'])->name('items.index');

        // カートページ
        Route::get('cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('cart/store', [CartController::class, 'store'])->name('cart.store');
        Route::post('cart/update', [CartController::class, 'update'])->name('cart.update');
        Route::post('cart/delete', [CartController::class, 'delete'])->name('cart.delete');
        Route::post('cart/clear', [CartController::class, 'clear'])->name('cart.clear');

        // 配送先設定ページ
        Route::get('shipping', [ShippingController::class, 'index'])->name('shipping.index');
        Route::post('shipping/store', [ShippingController::class, 'store'])->name('shipping.store');

        // 購入確認ページ
        Route::get('confirm', [ConfirmController::class, 'index'])->name('confirm.index');
        Route::post('confirm/store', [ConfirmController::class, 'store'])->name('confirm.store');

        // 購入完了ページ
        Route::get('complete', [CompleteController::class, 'index'])->name('complete.index');
    });
});

//認証ページ
require __DIR__ . '/auth.php';
