<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartProcessController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\PaymentController;

require __DIR__ . '/auth.php'; // Import routes từ Breeze

Route::get('/', [BookController::class, 'getall'])->name('home');
Route::get('/books/filter', [BookController::class, 'filter'])->name('filter');
Route::get('/books/detail/{id}', [BookController::class, 'getdetail'])->name('detail');
Route::get('/books/search', [BookController::class, 'search'])->name('search');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
//Liên hệ
Route::post('/contact', [ContactController::class, 'sendEmail'])->name('contact.send');

//Chatbot
Route::post('/chat', [App\Http\Controllers\ChatbotController::class, 'chat'])->name('chat');

// Route yêu cầu đăng nhập
Route::middleware(['user', 'auth'])->group(function () {
    //Giỏ hàng khách hàng
    Route::post('/cart/buynow/{id}', [CartProcessController::class, 'add2Cart'])->name('cart.add');
    Route::get('/buynow/{id}', [OrderController::class, 'buynow_view'])->name('buynow-v');
    Route::post('/buynow/{id}', [OrderController::class, 'buynow'])->name('buynow');
    Route::get('/cart', [CartProcessController::class, 'getcart'])->name('cart');
    Route::post('/cart/update', [CartProcessController::class, 'updateCart'])->name('cart.update');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout');
    Route::delete('/cart/clear', [CartProcessController::class, 'clearAll'])->name('cart.clear');
    Route::delete('/cart/remove/{id}', [CartProcessController::class, 'destroy'])->name('cart.remove');

    //Đơn hàng
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/search', [OrderController::class, 'searchdById'])->name('orders.search');
    Route::get('/orders/detail/{id}', [OrderController::class, 'show'])->name('orders.details');
    Route::post('/orders/detail/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/orders/{id}/payment', [OrderController::class, 'cancel'])->name('orders.payment');

    //Tài khoản khách hàng
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/password-change', [ProfileController::class, 'edit'])->name('profile.password-change');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //VN PAY
    Route::post('/vnpay/payment/{id}', [CheckoutController::class, 'vnpay_payment'])->name('checkout.vnpay');
    Route::get('/vnpay/payment/{id}/return', [PaymentController::class, 'handleVnpayReturn'])->name('vnpay.return');

    //Rating và Review
    Route::post('/review', [App\Http\Controllers\BookReviewController::class, 'store'])->name('book.review');
});

Route::middleware(['user'])->group(function () {
    Route::get('/profile/delete-account', [ProfileController::class, 'edit'])->name('profile.delete-account');
});


Route::middleware(['admin', 'auth'])->group(function () {
    //Trang chủ
    // Route::get('/admin/home', [BookController::class, 'getall'])->name('admin.home');
    // Route::get('/admin/home/detail/{id}', [BookController::class, 'getdetail'])->name('admin.detail');
    // Route::get('/admin/home/search', [BookController::class, 'search'])->name('admin.search');
    // Route::get('/admin/home/filter', [BookController::class, 'filter'])->name('admin.filter');
    //Trang quản lý
    // Route::get('/admin/index', [AdminController::class, 'index'])->name('admin.index');

    //Quản lý sách
    Route::get('/admin/bookmanagement', [AdminController::class, 'book_m'])->name('admin.book-m');
    Route::get('/admin/bookmanagement/search', [AdminController::class, 'book_m_search'])->name('admin.book-m.search');
    Route::get('/admin/bookmanagement/edit/{id}', [AdminController::class, 'book_m_show'])->name('admin.book-m.detail');
    Route::get('/admin/bookmanagement/add', [AdminController::class, 'book_m_add_v'])->name('admin.book-m.add');
    Route::post('/admin/bookmanagement/add', [AdminController::class, 'book_m_add'])->name('admin.book-m.store');
    Route::patch('/admin/bookmanagement/update/{id}', [AdminController::class, 'book_m_update'])->name('admin.book-m.update');
    Route::delete('/admin/bookmanagement/delete/{id}', [AdminController::class, 'destroyBook'])->name('admin.book-m.delete');

    //Quản lý tài khoản
    Route::get('/admin/usermanagement', [AdminController::class, 'user_m'])->name('admin.user-m');
    Route::get('/admin/usermanagement/detail/{id}', [AdminController::class, 'user_m_detail'])->name('admin.user-m.detail');
    Route::get('/admin/usermanagement/search', [AdminController::class, 'user_m_search'])->name('admin.user-m.search');
    Route::delete('/admin/usermanagement/delete/{id}', [AdminController::class, 'destroyUser'])->name('admin.delete_user');

    //Quản lý hóa đơn
    Route::get('/admin/odrermanagement', [AdminController::class, 'order_m'])->name('admin.order-m');
    Route::get('/admin/odrermanagement/detail/{id}', [AdminController::class, 'order_m_show'])->name('admin.order-m.detail');
    Route::post('/admin/odrermanagement/detail/confrim/{id}', [OrderController::class, 'confirm'])->name('admin.order-confirm');
    Route::post('/admin/odrermanagement/detail/cancel/{id}', [OrderController::class, 'cancel'])->name('admin.order-cancel');


    //Giỏ hàng admin
    // Route::get('/admin/buynow/{id}', [OrderController::class, 'buynow_view'])->name('admin.buynow-v');
    // Route::post('/admin/buynow/{id}', [OrderController::class, 'buynow'])->name('admin.buynow');
    // Route::post('/admin/cart/add/{id}', [CartProcessController::class, 'add2Cart'])->name('admin.cart.add');
    // Route::get('/admin/cart', [CartProcessController::class, 'getcart'])->name('admin.cart');
    // Route::post('/admin/cart/update', [CartProcessController::class, 'updateCart'])->name('admin.cart-update');
    // Route::delete('/admin/cart/remove/{id}', [CartProcessController::class, 'destroy'])->name('admin.cart.remove');
    // Route::post('/admin/checkout', [OrderController::class, 'store'])->name('admin.checkout');
    //Đơn hàng
    // Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders');
    // Route::get('/admin/orders/detail/{id}', [OrderController::class, 'show'])->name('admin.order-detail');

    //Tài khoản admin
    Route::get('/admin/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('/admin/profile', [ProfileController::class, 'update'])->name('admin.profile.update');
    Route::get('/admin/profile/password-change', [ProfileController::class, 'edit'])->name('admin.profile.password-change');
    Route::get('/admin/profile/delete-account', [ProfileController::class, 'edit'])->name('admin.profile.delete-account');
    Route::delete('/admin/profile', [ProfileController::class, 'destroy'])->name('admin.profile.destroy');
});

Route::middleware(['deliverer', 'auth'])->group(function () {
    //Các thao tác của người gioa hàng
    // Route::get('/delivery', [DeliveryController::class, 'index'])->name('delivery.index');
    Route::get('/delivery/orders-management', [DeliveryController::class, 'ordersManagement'])->name('delivery.orders-m');
    Route::get('/delivery/orders-management/{id}', [DeliveryController::class, 'ordersDetail'])->name('delivery.orders-d');
    Route::post('/delivery/orders-management/{id}', [DeliveryController::class, 'ordersClaim'])->name('delivery.orders-cl');
    Route::post('/delivery/orders-management/{id}/disclaim', [DeliveryController::class, 'ordersDisclaim'])->name('delivery.orders-dcl');
    // Route::get('/delivery/orders-management/search', [DeliveryController::class, 'ordersSearch'])->name('delivery.orders-m.search');
    Route::get('/delivery/orders_management/search', [DeliveryController::class, 'ordersSearch'])->name('delivery.orders-m.search');
    Route::get('/delivery/my-orders', [DeliveryController::class, 'myOrders'])->name('delivery.my-orders');
    Route::get('/delivery/my-orders/detail/{id}', [DeliveryController::class, 'myOrdersDetail'])->name('delivery.my-orders-detail');
    Route::post('/delivery/my-orders/detail/{id}/delivered', [OrderController::class, 'delivered'])->name('delivery.delivered');
    Route::get('/delivery/my-delivered-orders', [DeliveryController::class, 'ordersDelivered'])->name('delivery.delivered-orders');
    //Tài khoản người giao hàng
    Route::get('/delivery/profile', [ProfileController::class, 'edit'])->name('delivery.profile.edit');
    Route::patch('/delivery/profile', [ProfileController::class, 'update'])->name('delivery.profile.update');
    Route::get('/delivery/profile/password-change', [ProfileController::class, 'edit'])->name('delivery.profile.password-change');
    Route::get('/delivery/profile/delete-account', [ProfileController::class, 'edit'])->name('delivery.profile.delete-account');
    Route::delete('/delivery/profile', [ProfileController::class, 'destroy'])->name('delivery.profile.destroy');
});
