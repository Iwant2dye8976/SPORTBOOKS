<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getall()
    {
        $books = Book::all();
        $totalBooks = $books->count();
        return view('books.home', compact('books', 'totalBooks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getdetail($id)
    {
        $book = Book::find($id);
        return view('books.detail', compact('book'));
    }

    public function processCart(Request $request)
{
    $amount = $request->input('amount');
    $action = $request->input('action'); // Xác định nút nào được bấm
    $book = Book::find($request['id']);

    if ($action === 'buy_now') {
        // Xử lý mua ngay
        return view('books.checkout', compact('amount','book'));
    } elseif ($action === 'add_to_cart') {
        // Xử lý thêm vào giỏ hàng
        // Ví dụ: Lưu sản phẩm vào session hoặc database
        // Cart::add([
        //     'id' => 1, // ID sản phẩm (thay bằng sản phẩm thực tế)
        //     'quantity' => $amount,
        // ]);

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }

    return redirect()->back()->with('error', 'Hành động không hợp lệ!');
}


    public function search(Request $request)
    {
        $keyword = $request['keyword'];
        $books = Book::whereRaw('LOWER(title) LIKE ?', ['%'.strtolower($keyword).'%'])->get();
        $totalBooks = Book::where('title', 'LIKE', '%'.$keyword.'%')->count();
        return view('books.home', compact('books', 'totalBooks'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
