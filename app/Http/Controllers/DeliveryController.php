<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('deliverer.index');
    }


    public function ordersManagement()
    {
        $orders = Order::with('user')->orderBy('updated_at', 'desc')->whereIn('status', [2])->paginate(10);
        $order_count = Order::whereIn('status', [2])->count();
        return view('deliverer.index', compact('orders', 'order_count'));
    }

    public function ordersDetail(Request $request)
    {
        $order_details = OrderDetail::with('book')->where('order_id', $request->id)->get();
        $product_count = OrderDetail::where('order_id', $request->id)->count();
        $order_information = Order::with('user')->where('id', $request->id)->first();
        return view('deliverer.index', compact('order_details', 'product_count', 'order_information'));
    }

    public function ordersClaim(Request $request)
    {
        $order = Order::where('id', $request->id)->first();
        $order->status = 3;
        $order->deliverer_id = Auth::user()->id;
        $order->save();
        $orders = Order::with('user')->orderBy('updated_at', 'desc')->whereIn('status', [2])->paginate(10);
        $order_count = Order::whereIn('status', [2])->count();
        return redirect()->back()->with('success', 'Bạn đã nhận giao đơn hàng(Mã đơn: ' . $request->id . ")");
    }

    public function ordersSearch(Request $request)
    {
        $keyword = trim($request->input('keyword', ''));

        $query = Order::query();

        if (!empty($keyword)) {
            $query->where('status', 2)
                ->where(function ($q) use ($keyword) {
                    $q->whereRaw('LOWER(recipient_name) LIKE ?', ['%' . strtolower($keyword) . '%']);

                    if (is_numeric($keyword)) {
                        $q->orWhere('id', (int)$keyword);
                    }
                });
        } else {
            // Nếu không có từ khóa tìm kiếm, vẫn lọc theo status = 2
            $query->where('status', 2);
        }



        $orders = $query->orderBy('updated_at', 'desc')->paginate(10);
        $order_count = $orders->total();

        return view('deliverer.index', compact('orders', 'order_count'));
    }
}
