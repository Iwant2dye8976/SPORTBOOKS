<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
class CartProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function processCart(Request $request)
{
    // Kiểm tra nếu chưa đăng nhập
    if (!Auth::check()) {
        return redirect()->route('books.detail', $request['id'])->with('error', 'Bạn cần đăng nhập để thực hiện hành động này.');
    }

    $amount = $request->input('amount');
    $action = $request->input('action'); // Xác định nút nào được bấm
    $book = Book::find($request->id);

    if (!$book) {
        return redirect()->back()->with('error', 'Sách không tồn tại.');
    }

    if ($action === 'buy_now') {
        // Chuyển hướng đến trang thanh toán
        return view('books.checkout', compact('amount', 'book'));
    } elseif ($action === 'add_to_cart') {
        // Xử lý thêm vào giỏ hàng (lưu vào session hoặc database)
        // Cart::add(['id' => $book->id, 'quantity' => $amount]);

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }

    return redirect()->back()->with('error', 'Hành động không hợp lệ!');
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
