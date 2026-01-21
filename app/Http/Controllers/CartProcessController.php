<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Helpers\InteractionHelper;

class CartProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function add2Cart(Request $request)
    {
        $amount = $request->input('amount');
        $book = Book::find($request->id);

        if (!$book) {
            return redirect()->back()->with('error', 'Sách không tồn tại.');
        }

        InteractionHelper::log(
            'add_to_cart',
            $book->id,
            auth()->id(),
            [
                'quantity' => $amount ?? 1,
            ]
        );

        Cart::create([
            'user_id' => Auth::user()->id,
            'book_id' => $book->id,
            'book_quantity' => $amount == null ? 1 : $amount,
        ]);

        $book->decrement('stock', $amount == null ? 1 : $amount);

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
        // return redirect()->back()->with('error', 'Hành động không hợp lệ!');
    }

    public function getCart()
    {
        $cartItems = Auth::user()->cart()->with('book')->get(); // Lấy giỏ hàng và thông tin sách
        $cart_count = 0;
        $order_count = 0;
        $total_price = $cartItems->sum(fn($item) => $item->book->price * $item->book_quantity); // Tính tổng tiền
        $user = Auth::user();
        if (Auth::check()) {
            $cart_count = $cartItems->count();
            $order_count = Order::where('user_id', Auth::user()->id)->count();
            // if (Auth::user()->type === 'admin') {
            //     return view('admin.cart', compact('cartItems', 'cart_count', 'total_price', 'user', 'order_count'));
            // }
        }
        return view('user.cart', compact('cartItems', 'cart_count', 'total_price', 'user', 'order_count'));
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

        $oldQuantity = $cartItem ? $cartItem->book_quantity : 0;

        if ($cartItem) {
            $cartItem->update(['book_quantity' => $request->quantity]);
            $book = Book::find($request->book_id);
            $change = $oldQuantity - $request->quantity;
            if ($change > 0) {
                $book->increment('stock', $change);
            } else {
                $book->decrement('stock', abs($change));
            }
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'book_id' => $request->book_id,
                'book_quantity' => $request->quantity
            ]);
        }



        return response()->json(['success' => true]);
    }

    public function clearAll()
    {
        $cart = Cart::where('user_id', Auth::id());
        foreach ($cart->get() as $item) {
            $book = Book::find($item->book_id);
            $book->increment('stock', $item->book_quantity);
        }
        $cart->delete();
        return redirect()->back()->with('success', 'Đã xóa tất cả sản phẩm khỏi giỏ hàng.');
    }

    public function destroy(Request $request)
    {
        $item = Auth::user()->cart()->find($request->id);

        if (!$item) {
            // if (Auth::check() && Auth::user()->type === 'admin') {
            //     return redirect()->route('admin.cart')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
            // }
            return redirect()->route('cart')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
        }


        if (Auth::check()) {
            // if (Auth::user()->type === 'admin') {
            //     return redirect()->route('admin.cart')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
            // } else {
            $book = Book::find($item->book_id);
            $book->increment('stock', $item->book_quantity);
            $item->delete();
            return redirect()->route('cart')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
            // }
        }
    }
}
