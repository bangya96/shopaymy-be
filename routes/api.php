<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\PageController;

// Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Shop Routes
    Route::get('/shops', [ShopController::class, 'index']);
    Route::post('/shops', [ShopController::class, 'store']);
    Route::get('/shops/{shop}', [ShopController::class, 'show']);
    Route::put('/shops/{shop}', [ShopController::class, 'update']);
    Route::delete('/shops/{shop}', [ShopController::class, 'destroy']);
    
    // Page Routes
    Route::get('/shops/{shop}/pages', [PageController::class, 'index']);
    Route::post('/shops/{shop}/pages', [PageController::class, 'store']);
    Route::get('/shops/{shop}/pages/{page}', [PageController::class, 'show']);
    Route::put('/shops/{shop}/pages/{page}', [PageController::class, 'update']);
    Route::delete('/shops/{shop}/pages/{page}', [PageController::class, 'destroy']);
});