<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $order->total = floatval(str_replace('$', '', $request['total-price']));
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

        return redirect()->route('admin.cart')->with('success', 'Đặt thành công, vui lòng chờ xử lý.');
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
