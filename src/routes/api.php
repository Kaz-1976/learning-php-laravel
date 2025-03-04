<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AddressController;

// Route::middleware('auth:sanctum')->get('/address/{code}', [AddressController::class, 'address'])->where('code', '[0-9]{7}');
Route::middleware('auth')->get('/address/{code}', [AddressController::class, 'address'])->where('code', '[0-9]{7}');
