<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartProcessController;

require __DIR__.'/auth.php'; // Import routes từ Breeze

Route::get('/home', [BookController::class, 'getall'])->name('home');

Route::get('admin/home', [BookController::class, 'getall'])->middleware('admin')->name('admin.home');

Route::get('/home/filter', [BookController::class, 'filter'])->name('filter');

Route::get('home/detail/{id}', [BookController::class, 'getdetail'])->name('user.detail');
Route::get('/home/search', [BookController::class, 'search'])->name('search');
// Route::get('/home', [BookController::class, 'search'])->name('search');

// Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
// Route yêu cầu đăng nhập
Route::middleware(['auth'])->group(function () {
    Route::post('/cart/checkout/{id}', [CartProcessController::class, 'processCart'])->name('cart.process');
    Route::get('/cart', [CartProcessController::class, 'getcart'])->name('cart');
    // Route::post('/cart', [CartProcessController::class, 'getcart'])->name('cart.remove');
    Route::delete('/cart/remove/{id}', [CartProcessController::class, 'destroy'])->name('cart.remove');
    // Route::get('/checkout', [BookController::class, 'index'])->name('checkout');
});

