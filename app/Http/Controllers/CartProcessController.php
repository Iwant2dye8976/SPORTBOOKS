<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\User;

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
        $cart_count = 0;
        $cart_count = Cart::where('user_id', Auth::user()->id)->count();
        $user_type = Auth::user()->type;

        if (!$book) {
            return redirect()->back()->with('error', 'Sách không tồn tại.');
        }

        if ($action === 'buy_now') {
            // Chuyển hướng đến trang thanh toán
            return view($user_type === 'user' ? 'user.buynow' : 'admin.buynow', compact('amount', 'book', 'cart_count'));
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
        $user = Auth::user();
        if (Auth::check() && Auth::user()->type === 'admin') {
            return view('admin.cart', compact('cartItems', 'cart_count', 'total_price', 'user'));
        }
        return view('user.cart', compact('cartItems', 'cart_count', 'total_price', 'user'));
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1|max:999',
        ]);

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('book_id', $request->book_id)
            ->first();

        if ($cartItem) {
            $cartItem->update(['book_quantity' => $request->quantity]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'book_id' => $request->book_id,
                'book_quantity' => $request->quantity
            ]);
        }

        return response()->json(['success' => true]);
    }


    public function destroy(Request $request)
    {
        $item = Auth::user()->carts()->find($request->id);

        if (!$item) {
            if (Auth::check() && Auth::user()->type === 'admin') {
                return redirect()->route('admin.cart')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
            }
            return redirect()->route('cart')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
        }

        $item->delete();
        if (Auth::check() && Auth::user()->type === 'admin') {
            return redirect()->route('admin.cart')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
        } else {
            return redirect()->route('cart')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
        }
    }
}
