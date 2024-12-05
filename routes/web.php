<?php

use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\ProductDetailController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::resource('products', ProductController::class);
Route::get('product/list', [ProductController::class, 'productList'])->name('product.list');

Route::prefix('products/details')->group(function() {
    Route::post('/store', [ProductDetailController::class, 'store']);
    Route::get('/', [ProductDetailController::class, 'index']);
    Route::put('/{id}', [ProductDetailController::class, 'update']);
    Route::delete('/{id}', [ProductDetailController::class, 'destroy']);
});
require __DIR__.'/auth.php';
