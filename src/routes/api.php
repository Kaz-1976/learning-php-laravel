<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ZipController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\ProductImageController;
use App\Http\Controllers\Api\ReceiptImageController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('zip/{code}', [ZipController::class, 'zip'])->where('code', '[0-9]{7}');
    Route::get('address/{id}', [AddressController::class, 'address'])->where('id', '[0-9]+');
    Route::get('product-image/{id}', [ProductImageController::class, 'show'])->where('id', '[0-9]+');
    Route::get('receipt-image/{id}/{no}', [ReceiptImageController::class, 'show'])->where('id', '[0-9]+')->where('no', '[0-9]+');
});
