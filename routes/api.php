<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\StoreUserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:api', 'role:super_admin'])->group(function () {
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