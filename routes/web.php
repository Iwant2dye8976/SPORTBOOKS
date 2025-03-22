<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartProcessController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;

require __DIR__ . '/auth.php'; // Import routes từ Breeze

//Trang chủ
Route::get('/home', [BookController::class, 'getall'])->name('home');
Route::get('/home/filter', [BookController::class, 'filter'])->name('filter');
Route::get('home/detail/{id}', [BookController::class, 'getdetail'])->name('user.detail');
Route::get('/home/search', [BookController::class, 'search'])->name('search');


// Route yêu cầu đăng nhập
Route::middleware(['auth'])->group(function () {
    //Giỏ hàng khách hàng
    Route::post('/cart/buynow/{id}', [CartProcessController::class, 'processCart'])->name('cart.process');
    Route::get('/cart', [CartProcessController::class, 'getcart'])->name('cart');
    Route::delete('/cart/remove/{id}', [CartProcessController::class, 'destroy'])->name('cart.remove');
    // Route::get('/checkout', [BookController::class, 'index'])->name('checkout');
    //Tài khoản khách hàng
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['admin'])->group(function () {
    //Trang chủ
    Route::get('admin/home', [BookController::class, 'getall'])->name('admin.home');
    Route::get('admin/home/detail/{id}', [BookController::class, 'getdetail'])->name('admin.detail');
    Route::get('admin/home/search', [BookController::class, 'search'])->name('admin.search');
    Route::get('admin/home/filter', [BookController::class, 'filter'])->name('admin.filter');
    //Trang quản lý
    Route::get('admin/index', [AdminController::class, 'index'])->name('admin.index');
    Route::get('admin/index/bookmanagement', [AdminController::class, 'book_m'])->name('admin.book-m');
    Route::get('admin/index/usermanagement', [AdminController::class, 'user_m'])->name('admin.user-m');
    //Giỏ hàng admin
    Route::post('admin/buynow/{id}', [CartProcessController::class, 'processCart'])->name('admin.cart.process');
    Route::get('admin/cart', [CartProcessController::class, 'getcart'])->name('admin.cart');
    Route::post('admin/cart/update', [CartProcessController::class, 'updateCart'])->name('admin.cart-update');
    Route::delete('admin/cart/remove/{id}', [CartProcessController::class, 'destroy'])->name('admin.cart.remove');
    Route::post('admin/checkout', [OrderController::class, 'store'])->name('admin.checkout');
    //Tài khoản admin
    Route::get('admin/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('admin/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::delete('admin/profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');
});
