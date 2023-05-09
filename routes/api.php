<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api.auth')->group(function () {
    Route::get('stores', [StoreController::class, 'index'])->name('stores');
    Route::post('stores/create', [StoreController::class, 'store'])->name('stores.create');
    Route::put('stores/{id}', [StoreController::class, 'update'])->name('stores.update');
    Route::delete('stores/{id}', [StoreController::class, 'destroy'])->name('stores.delete');

    Route::get('stores/{store_id}/products', [ProductController::class, 'index'])->name('products');
    Route::post('stores/{store_id}/products/create', [ProductController::class, 'store'])->name('products.create');
    Route::put('stores/{store_id}/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('stores/{store_id}/products/{id}', [ProductController::class, 'destroy'])->name('products.delete');
});
Route::post('login', [AuthController::class, 'login'])->name('login');
