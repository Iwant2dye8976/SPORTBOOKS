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
        $orders = Order::with('user')->where('user_id', Auth::user()->id)->orderBy('updated_at', 'desc')->paginate(10);
        $order_count = Order::where('user_id', Auth::user()->id)->whereIn('status', [-1, 0, 1])->count();
        $cart_count = Cart::where('user_id', Auth::user()->id)->count();
        return view('user.orders', compact('orders', 'order_count', 'cart_count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function buynow_view(Request $request)
    {
        $book = Book::where('id', $request->id)->first();
        $user = User::where('id', Auth::user()->id)->first();
        $cart_count = Cart::where('user_id', Auth::user()->id)->count();
        $order_count = Order::where('user_id', Auth::user()->id)->whereIn('status', [-1, 0, 1])->count();
        return view('user.buynow', compact('book', 'user', 'cart_count', 'cart_count', 'order_count'));
    }

    public function buynow(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'shipping_address' => 'required|string|max:255',
            'phone_number' => ['required', 'regex:/^(03|05|07|08|09|01[2689])[0-9]{8}$/'],
            'total-price' => 'required|numeric',
            'note' => ['nullable', 'max:255'],
        ], [
            'recipient_name.max' => 'Tên quá dài.',
            'shipping_address.max' => 'Địa chỉ quá dài.',
            'recipient_name.required' => 'Vui lòng nhập họ và tên.',
            'shipping_address.required' => 'Vui lòng nhập địa chỉ.',
            'phone_number.required' => 'Vui lòng nhập số điện thoại.',
            'phone_number.regex' => 'Số điện thoại không hợp lệ.',
            'total-price.required' => 'Vui lòng nhập tổng tiền.',
            'note.max' => 'Độ dài của ghi chú không được vượt quá 255 ký tự.',
        ]);
        $book = Book::where('id', $request->id)->first();

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->recipient_name = $request->recipient_name;
        $order->shipping_address = $request->shipping_address;
        $order->phone_number = $request->phone_number;
        $order->note = $request->note;
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
            'recipient_name' => 'required|string|max:255',
            'shipping_address' => 'required|string|max:255',
            'phone_number' => ['required', 'regex:/^(03|05|07|08|09|01[2689])[0-9]{8}$/'],
            'total-price' => 'required|numeric',
            'note' => ['nullable', 'max:255'],
        ], [
            'recipient_name.max' => 'Tên quá dài.',
            'shipping_address.max' => 'Địa chỉ quá dài.',
            'recipient_name.required' => 'Vui lòng nhập họ và tên.',
            'shipping_address.required' => 'Vui lòng nhập địa chỉ.',
            'phone_number.required' => 'Vui lòng nhập số điện thoại.',
            'phone_number.regex' => 'Số điện thoại không hợp lệ.',
            'total-price.required' => 'Vui lòng nhập tổng tiền.',
            'note.max' => 'Độ dài của ghi chú không được vượt quá 255 ký tự.',
        ]);

        $items = Cart::where('user_id', Auth::user()->id)->get();

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->recipient_name = $request->recipient_name;
        $order->shipping_address = $request->shipping_address;
        $order->phone_number = $request->phone_number;
        $order->note = $request->note;
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

        return redirect()->route('cart')->with('success', 'Đặt thành công, vui lòng chờ xử lý.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $order_details = OrderDetail::with('book')->where('order_id', $request->id)->get();
        $product_count = OrderDetail::where('order_id', $request->id)->count();
        $cart_count = Cart::where('user_id', Auth::user()->id)->count();
        $order_count = Order::where('user_id', Auth::user()->id)->whereIn('status', [-1, 0, 1])->count();
        $order_information = Order::with('user')->where('id', $request->id)->first();
        return view('user.order-details', compact('order_details', 'product_count', 'cart_count', 'order_count', 'order_information'));
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

    if (!$order) {
        return response()->json(['success' => false, 'message' => 'Không tìm thấy đơn hàng'], 404);
    }

    $order->update(['status' => $request->status]);

    return response()->json([
        'success' => true,
        'message' => 'Cập nhật thành công',
        'order' => $order
    ]);
}


    public function cancel(Request $request)
    {
        $order = Order::where('id', $request->order_id)->first();
        $order->status = 0;
        $order->save();
        return redirect()->back()->with('success', 'Đơn hàng đã được hủy.');
    }
}
