<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartProcessController;

require __DIR__.'/auth.php'; // Import routes từ Breeze

Route::get('/home', [BookController::class, 'getall'])->name('home');
Route::get('book/detail/{id}', [BookController::class, 'getdetail'])->name('books.detail');
Route::get('/home/search', [BookController::class, 'search'])->name('search');
// Route::get('/home', [BookController::class, 'search'])->name('search');

// Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
// Route yêu cầu đăng nhập
Route::middleware(['auth'])->group(function () {
    Route::post('/cart/checkout/{id}', [CartProcessController::class, 'processCart'])->name('cart.process');
    // Route::get('/checkout', [BookController::class, 'index'])->name('checkout');
});

