<?php

use App\Http\Controllers\backend\ClientController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\ProductDetailController;
use App\Http\Controllers\backend\QuotationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('backend.dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        
    Route::resource('products', ProductController::class);
    Route::get('product/list', [ProductController::class, 'productList'])->name('product.list');

    Route::post('product/details/store', [ProductDetailController::class, 'store'])->name('product.detail.store');
    Route::get('product/details', [ProductDetailController::class, 'index'])->name('product.detail.index');
    Route::get('product/details/table', [ProductDetailController::class, 'table'])->name('product.detail.table');
    Route::get('product/details/update/{id}', [ProductDetailController::class, 'edit'])->name('product.detail.edit');
    Route::delete('product/details/delete/{id}', [ProductDetailController::class, 'destroy']);

    Route::get('clients',[ClientController::class,'index'])->name('client.index');
    Route::get('clients/table', [ClientController::class, 'table'])->name('client.table');
    Route::post('clients/store', [ClientController::class, 'store'])->name('client.store');
    Route::get('clients/edit/{id}', [ClientController::class, 'edit'])->name('client.edit');
    Route::delete('clients/delete/{id}', [ClientController::class, 'destroy']);

    Route::get('quotation',[QuotationController::class,'index'])->name('quotation.index');
    Route::get('quatation/table',[QuotationController::class,'table'])->name('quotation.table');
    Route::post('quotation/store', [QuotationController::class, 'store'])->name('quotation.store');
    Route::get('quotation/edit/{id}', [QuotationController::class, 'edit'])->name('quotation.edit');
    Route::delete('quotation/delete/{id}', [QuotationController::class, 'destroy']);

    Route::get('quotation/details', [QuotationController::class, 'quotationDetails'])->name('quotation.details');
    Route::get('quotation/details/table', [QuotationController::class, 'quotationDetailsTable'])->name('quotation.details.table');
    Route::post('quotation/details/store', [QuotationController::class, 'quotationDetailsStore'])->name('quotation.details.store');
    Route::get('quotation/details/edit/{id}', [QuotationController::class, 'quotationDetailsEdit'])->name('quotation.details.edit');
    Route::delete('quotation/details/delete/{id}', [QuotationController::class, 'quotationDetailsDelete'])->name('quotation.details.delete');

});
require __DIR__.'/auth.php';
