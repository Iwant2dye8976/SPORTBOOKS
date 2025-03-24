<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\Order;
use App\Models\Cart;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function book_m()
    {
        $books = Book::paginate(10);
        return view('admin.index', compact('books'));
    }

    public function user_m()
    {
        $users = User::paginate(10);
        return view('admin.index', compact('users'));
    }

    public function order_m()
    {
        $orders = Order::paginate(10);
        return view('admin.index', compact('orders'));
    }

    public function order_m_show(Request $request)
    {
        $product_count = OrderDetail::where('order_id', $request->id)->count();
        $order_details = OrderDetail::with('book')->where('order_id', $request->id)->get();
        $order_information = Order::with('user')->where('id', $request->id)->first();
        return view('admin.index', compact('product_count', 'order_details', 'order_information'));
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
