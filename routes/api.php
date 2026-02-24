<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\StoreUserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::put('/auth/profile', [AuthController::class, 'updateProfile']);
});

Route::middleware(['auth:api', 'role:super_admin'])->group(function () {
    // super admin manage toko
    Route::get('/stores', [StoreController::class, 'index']);
    Route::post('/stores', [StoreController::class, 'store']);
    Route::get('/stores/{id}', [StoreController::class, 'show']);
    Route::put('/stores/{id}', [StoreController::class, 'update']);
    Route::delete('/stores/{id}', [StoreController::class, 'destroy']);

    // super admin manage user per toko 
    Route::get('/stores/{storeId}/users', [StoreUserController::class, 'index']);
    Route::get('/stores/{storeId}/users/{userId}', [StoreUserController::class, 'show']);
    Route::put('/stores/{storeId}/users/{userId}', [StoreUserController::class, 'update']);
    Route::delete('/stores/{storeId}/users/{userId}', [StoreUserController::class, 'destroy']);
});

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    // admin manage kasir bedasarkan storeId nya
    Route::get('/stores/{storeId}/cashiers', [CashierController::class, 'index']);
    Route::post('/stores/{storeId}/cashiers', [CashierController::class, 'store']);
    Route::get('/stores/{storeId}/cashiers/{userId}', [CashierController::class, 'show']);
    Route::put('/stores/{storeId}/cashiers/{userId}', [CashierController::class, 'update']);
    Route::delete('/stores/{storeId}/cashiers/{userId}', [CashierController::class, 'destroy']);

    // admin manage product bedasarkan storeId nya
    Route::get('/stores/{storeId}/products', [ProductController::class, 'index']);
    Route::post('/stores/{storeId}/products', [ProductController::class, 'store']);
    Route::get('/stores/{storeId}/products/{productId}', [ProductController::class, 'show']);
    Route::put('/stores/{storeId}/products/{productId}', [ProductController::class, 'update']);
    Route::delete('/stores/{storeId}/products/{productId}', [ProductController::class, 'destroy']);

    // menampilkan data penjualan
    Route::get('/stores/{storeId}/sales', [SaleController::class, 'index']);
    Route::get('/stores/{storeId}/sales/{saleId}', [SaleController::class, 'show']);
});

Route::middleware(['auth:api', 'role:kasir'])->group(function () {
    Route::get('/stores/{storeId}/products', [ProductController::class, 'index']);

    // create penjualan by kasir
    Route::post('/stores/{storeId}/sales', [SaleController::class, 'createSale']);

    Route::get('/stores/{storeId}/sales', [SaleController::class, 'index']);
    Route::get('/stores/{storeId}/sales/{saleId}', [SaleController::class, 'show']);
});