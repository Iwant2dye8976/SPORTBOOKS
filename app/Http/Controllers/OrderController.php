<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('updated_at','desc')->paginate(10);
        $order_count = Order::where('user_id', Auth::user()->id)->where('status', -1)->count();
        $cart_count = Cart::where('user_id', Auth::user()->id)->count();
        return view(Auth::user()->type === 'admin' ? 'admin.orders' : 'user.orders', compact('orders', 'order_count', 'cart_count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function buynow_view(Request $request)
    {
        $book = Book::where('id', $request->id)->first();
        $user = User::where('id', Auth::user()->id)->first();
        $cart_count = Cart::where('user_id', Auth::user()->id)->count();
        $order_count = Order::where('user_id', Auth::user()->id)->count();
        return view(Auth::user()->type === 'admin' ? 'admin.buynow' : 'user.buynow', compact('book', 'user', 'cart_count', 'cart_count', 'order_count'));
    }

    public function buynow(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'phone-number' => 'required|regex:/^[0-9\-\+\s]+$/',
            'total-price' => 'required|numeric',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'phone-number.required' => 'Vui lòng nhập số điện thoại.',
            'total-price.required' => 'Vui lòng nhập tổng tiền.',
        ]);
        $book = Book::where('id', $request->id)->first();

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->note = $request['name'] . ". " . $request['address'] . ". SDT: " . $request['phone-number'];
        $order->shipping_fee = $request['shipping'];
        $order->books_price = $request['books-price'];
        $order->save();

        OrderDetail::create([
            'book_id'   => $request->id,
            'order_id'  => $order->id,
            'book_quantity'  => $request->quantity,
            'price'     => $book->price,
        ]);
        return redirect()->back()->with('success', 'Đặt thành công, vui lòng chờ xử lý');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'phone-number' => 'required|regex:/^[0-9\-\+\s]+$/',
            'total-price' => 'required|numeric',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'phone-number.required' => 'Vui lòng nhập số điện thoại.',
            'total-price.required' => 'Vui lòng nhập tổng tiền.',
        ]);

        $items = Cart::where('user_id', Auth::user()->id)->get();

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->note = $request['name'] . ". " . $request['address'] . ". SDT: " . $request['phone-number'];
        $order->shipping_fee = $request['shipping'];
        $order->books_price = $request['books-price'];
        $order->save();

        foreach ($items as $item) {
            OrderDetail::create([
                'book_id'   => $item->book_id,
                'order_id'  => $order->id,
                'book_quantity'  => $item->book_quantity,
                'price'     => $item->book->price,
            ]);
        }

        Cart::where('user_id', Auth::user()->id)->delete();

        return redirect()->route(Auth::user()->type === 'admin' ? 'admin.cart' : 'cart')->with('success', 'Đặt thành công, vui lòng chờ xử lý.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $order_details = OrderDetail::with('book')->where('order_id', $request->id)->get();
        $product_count = OrderDetail::where('order_id', $request->id)->count();
        $cart_count = Cart::where('user_id', Auth::user()->id)->count();
        $order_count = Order::where('user_id', Auth::user()->id)->where('status', -1)->count();
        $order_information = Order::with('user')->where('id', $request->id)->first();
        return view(Auth::user()->type === 'user' ? 'user.order-details' : 'admin.order-details', compact('order_details', 'product_count', 'cart_count', 'order_count', 'order_information'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:orders,id',
            'status' => 'required|integer',
        ]);

        $order = Order::where('id', $request->id)->first();


        $order->update(['status' => $request->status]);
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy đơn hàng'], 404);
        }

        return response()->json(['success' => true, 'message' => 'Cập nhật thành công']);
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
