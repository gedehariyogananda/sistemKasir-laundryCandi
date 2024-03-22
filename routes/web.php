<?php

use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\UserPurchasedController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/data-customer/entry-data')->name('purchased.')->group(function () {
    Route::get('/', [UserPurchasedController::class, 'index'])->name('index');
    Route::get('/create', [UserPurchasedController::class, 'create'])->name('create');
    Route::get('/created', [UserPurchasedController::class, 'created'])->name('get');
    Route::post('/create', [UserPurchasedController::class, 'store'])->name('store');
    Route::get('/pemesanan', [UserPurchasedController::class, 'edit'])->name('edit');
    Route::patch('/edit', [UserPurchasedController::class, 'update'])->name('update');
    Route::patch('/delete-pemesanan/{id}', [UserPurchasedController::class, 'destroyPemesanan'])->name('destroyPemesanan');
});

Route::get('/checkout-customer', [PaymentMethodController::class, 'index'])->name('checkout.index');
Route::patch('/checkout-customer/update/{id}', [PaymentMethodController::class, 'update'])->name('checkout.update');
Route::get('/nota-customer/{id}', [UserPurchasedController::class, 'nota'])->name('nota.index');
Route::delete('/pemesanan/{id}/delete', [UserPurchasedController::class, 'destroy'])->name('nota.delete');
