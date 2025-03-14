<?php

use App\Http\Controllers\Auth;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('home');
// });
Route::get('/', [BookController::class, 'getall'])->name('books.home');
Route::get('/book/detail/{id}', [BookController::class, 'getdetail'])->name('books.detail');
Route::post('/book/detail/{id}/process', [BookController::class, 'processCart'])->name('cart.process');
Route::get('/book/search', [BookController::class, 'search'])->name('search');
Route::get('/login', [Auth::class, 'loginView'])->name('login');
// Route::get('/checkout', function(){ return view('books.checkout');} )->name('checkout');