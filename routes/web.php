<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartProcessController;

require __DIR__.'/auth.php'; // Import routes từ Breeze

Route::get('/home', [BookController::class, 'getall'])->name('home');
Route::get('/home/filter', [BookController::class, 'filter'])->name('filter');
Route::get('home/detail/{id}', [BookController::class, 'getdetail'])->name('user.detail');
Route::get('/home/search', [BookController::class, 'search'])->name('search');


// Route yêu cầu đăng nhập
Route::middleware(['auth'])->group(function () {
    Route::post('/cart/checkout/{id}', [CartProcessController::class, 'processCart'])->name('cart.process');
    Route::get('/cart', [CartProcessController::class, 'getcart'])->name('cart');
    Route::delete('/cart/remove/{id}', [CartProcessController::class, 'destroy'])->name('cart.remove');
    // Route::get('/checkout', [BookController::class, 'index'])->name('checkout');
});

Route::middleware(['admin'])->group(function () {
    Route::get('admin/home', [BookController::class, 'getall'])->name('admin.home');
    Route::get('admin/home/detail/{id}', [BookController::class, 'getdetail'])->name('admin.detail');
    Route::get('admin/home/search', [BookController::class, 'search'])->name('admin.search');
    Route::get('admin/home/filter', [BookController::class, 'filter'])->name('admin.filter');
});

Route::middleware(['admin','auth'])->group(function () {
    Route::post('admin/cart/checkout/{id}', [CartProcessController::class, 'processCart'])->name('admin.cart.process');
    Route::get('admin/cart', [CartProcessController::class, 'getcart'])->name('admin.cart');
    Route::delete('admin/cart/remove/{id}', [CartProcessController::class, 'destroy'])->name('admin.cart.remove');
    // Route::get('/checkout', [BookController::class, 'index'])->name('checkout');
});

