<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartProcessController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;

require __DIR__ . '/auth.php'; // Import routes từ Breeze

//Trang chủ
Route::get('/home', [BookController::class, 'getall'])->name('home');
Route::get('/home/filter', [BookController::class, 'filter'])->name('filter');
Route::get('home/detail/{id}', [BookController::class, 'getdetail'])->name('detail');
Route::get('/home/search', [BookController::class, 'search'])->name('search');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'sendEmail'])->name('contact.send');


// Route yêu cầu đăng nhập
Route::middleware(['auth'])->group(function () {
    //Giỏ hàng khách hàng
    Route::post('/cart/buynow/{id}', [CartProcessController::class, 'add2Cart'])->name('cart.add');
    Route::get('/buynow/{id}', [OrderController::class, 'buynow_view'])->name('buynow-v');
    Route::post('/buynow/{id}', [OrderController::class, 'buynow'])->name('buynow');
    Route::get('/cart', [CartProcessController::class, 'getcart'])->name('cart');
    Route::post('/cart/update', [CartProcessController::class, 'updateCart'])->name('cart.update');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout');
    Route::delete('/cart/remove/{id}', [CartProcessController::class, 'destroy'])->name('cart.remove');
    //Đơn hàng
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/detail/{id}', [OrderController::class, 'show'])->name('orders.details');
    Route::patch('/orders/detail/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    //Tài khoản khách hàng
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['admin'])->group(function () {
    //Trang chủ
    Route::get('/admin/home', [BookController::class, 'getall'])->name('admin.home');
    Route::get('/admin/home/detail/{id}', [BookController::class, 'getdetail'])->name('admin.detail');
    Route::get('/admin/home/search', [BookController::class, 'search'])->name('admin.search');
    Route::get('/admin/home/filter', [BookController::class, 'filter'])->name('admin.filter');
    //Trang quản lý
    Route::get('/admin/index', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/index/bookmanagement', [AdminController::class, 'book_m'])->name('admin.book-m');
    Route::get('/admin/index/bookmanagement/edit/{id}', [AdminController::class, 'book_m_show'])->name('admin.book-m.detail');
    Route::patch('/admin/index/bookmanagement/update/{id}', [AdminController::class, 'book_m_update'])->name('admin.book-m.update');
    Route::delete('/admin/index/bookmanagement/delete/{id}', [AdminController::class, 'destroyBook'])->name('admin.book-m.delete');
    Route::get('/admin/index/usermanagement', [AdminController::class, 'user_m'])->name('admin.user-m');
    Route::delete('/admin/index/usermanagement/delete/{id}', [AdminController::class, 'destroyUser'])->name('admin.delete_user');
    Route::get('/admin/index/odrermanagement', [AdminController::class, 'order_m'])->name('admin.order-m');
    Route::get('/admin/index/odrermanagement/detail/{id}', [AdminController::class, 'order_m_show'])->name('admin.order-m.detail');
    //Giỏ hàng admin
    Route::get('/admin/buynow/{id}', [OrderController::class, 'buynow_view'])->name('admin.buynow-v');
    Route::post('/admin/buynow/{id}', [OrderController::class, 'buynow'])->name('admin.buynow');
    Route::post('/admin/cart/add/{id}', [CartProcessController::class, 'add2Cart'])->name('admin.cart.add');
    Route::get('/admin/cart', [CartProcessController::class, 'getcart'])->name('admin.cart');
    Route::post('/admin/cart/update', [CartProcessController::class, 'updateCart'])->name('admin.cart-update');
    Route::delete('/admin/cart/remove/{id}', [CartProcessController::class, 'destroy'])->name('admin.cart.remove');
    Route::post('/admin/checkout', [OrderController::class, 'store'])->name('admin.checkout');
    Route::post('/admin/order/update', [OrderController::class, 'edit'])->name('admin.order-update');
    //Đơn hàng
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders');
    Route::get('/admin/orders/detail/{id}', [OrderController::class, 'show'])->name('admin.order-detail');
    //Tài khoản admin
    Route::get('/admin/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('/admin/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::delete('/admin/profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');
});
