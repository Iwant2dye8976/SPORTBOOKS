<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function processCart(Request $request)
    {
        $amount = $request->input('amount');
        $action = $request->input('action'); // Xác định nút nào được bấm
        $book = Book::find($request->id);
        $cart_count = Cart::with('user_id', '=', Auth::user()->id)->count();

        if (!$book) {
            return redirect()->back()->with('error', 'Sách không tồn tại.');
        }

        if ($action === 'buy_now') {
            // Chuyển hướng đến trang thanh toán
            return view('user.checkout', compact('amount', 'book', 'cart_count'));
        } elseif ($action === 'add_to_cart') {
            // Xử lý thêm vào giỏ hàng (lưu vào session hoặc database)
            Cart::create([
                'user_id' => Auth::user()->id,
                'book_id' => $book->id,
                'book_quantity' => $amount
            ]);
            return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
        }

        return redirect()->back()->with('error', 'Hành động không hợp lệ!');
    }

    public function getCart()
    {
        $cartItems = Auth::user()->carts()->with('book')->get(); // Lấy giỏ hàng và thông tin sách
        $cart_count = $cartItems->count();
        $total_price = $cartItems->sum(fn($item) => $item->book->price * $item->book_quantity); // Tính tổng tiền

        return view('user.cart', compact('cartItems', 'cart_count', 'total_price'));
    }

    public function destroy(Request $request)
    {
        $item = Auth::user()->carts()->find($request->id);

        if (!$item) {
            return redirect()->route('cart')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
        }

        $item->delete();

        return redirect()->route('cart')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }
}
