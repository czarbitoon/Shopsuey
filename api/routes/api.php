<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




//proteted routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/products', [ProductController::class, 'getProducts']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/products', [ProductController::class,'createProduct']);
    Route::post('/checkout/{id}', [PaymentController::class, 'checkout']);
});
//public routes

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/success', [PaymentController::class, 'success'])->name('checkout.success');
Route::get('/cancel', [PaymentController::class, 'cancel'])->name('checkout.cancel');
