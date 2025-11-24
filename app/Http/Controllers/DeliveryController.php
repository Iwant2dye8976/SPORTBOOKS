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
        $my_orders = Order::where('status', 3)->where('deliverer_id', Auth::user()->id)->count();
        return view('deliverer.index', compact('orders', 'order_count', 'my_orders'));
    }

    public function myOrders()
    {
        $orders = Order::with('user')->orderBy('updated_at', 'desc')->where('status', 3)->where('deliverer_id', Auth::user()->id)->paginate(10);
        $order_count = Order::where('status', 2)->count();
        $my_orders = Order::where('status', 3)->where('deliverer_id', Auth::user()->id)->count();

        return view('deliverer.index', compact('orders', 'order_count', 'my_orders'));
    }

    public function ordersDetail(Request $request)
    {
        $order_details = OrderDetail::with('book')->where('order_id', $request->id)->get();
        $product_count = OrderDetail::where('order_id', $request->id)->count();
        $order_information = Order::with('user')->where('id', $request->id)->first();
        $order_count = Order::where('status', 2)->count();
        $my_orders = Order::where('status', 3)->where('deliverer_id', Auth::user()->id)->count();
        return view('deliverer.index', compact('order_details', 'product_count', 'order_information', 'order_count', 'my_orders'));
    }

    public function myOrdersDetail(Request $request)
    {
        $order_details = OrderDetail::with('book')->where('order_id', $request->id)->get();
        $product_count = OrderDetail::where('order_id', $request->id)->count();
        $order_information = Order::with('user')->where('id', $request->id)->first();
        $order_count = Order::where('status', 2)->count();
        $my_orders = Order::where('status', 3)->where('deliverer_id', Auth::user()->id)->count();
        return view('deliverer.index', compact('order_details', 'product_count', 'order_information', 'order_count', 'my_orders'));
    }

    public function ordersClaim(Request $request)
    {
        $order = Order::where('id', $request->id)->first();
        $order->status = 3;
        $order->deliverer_id = Auth::user()->id;
        $order->save();
        $orders = Order::with('user')->orderBy('updated_at', 'desc')->whereIn('status', [2])->paginate(10);
        $order_count = Order::whereIn('status', [2])->count();
        $my_orders = Order::where('status', 3)->where('deliverer_id', Auth::user()->id)->count();
        return redirect()->back()->with('success', 'Bạn đã nhận giao đơn hàng(Mã đơn: ' . $request->id . ")");
    }

    public function ordersDisclaim(Request $request)
    {
        $order = Order::where('id', $request->id)->first();
        $order->status = 2;
        $order->deliverer_id = null;
        $order->save();
        $orders = Order::with('user')->orderBy('updated_at', 'desc')->whereIn('status', [2])->paginate(10);
        $order_count = Order::whereIn('status', [2])->count();
        $my_orders = Order::where('status', 3)->where('deliverer_id', Auth::user()->id)->count();
        return redirect()->back()->with('success', 'Bạn đã thôi giao đơn hàng(Mã đơn: ' . $request->id . ")");
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
        $my_orders = Order::where('status', 3)->where('deliverer_id', Auth::user()->id)->count();
        return view('deliverer.index', compact('orders', 'order_count', 'my_orders'));
    }

    public function ordersDelivered(Request $request)
    {
        $orders = Order::where('deliverer_id', Auth::user()->id)->orderBy('updated_at', 'desc')->paginate(10);
        $d_count = $orders->where('status', 4)->count();
        $order_count = Order::where('status', 2)->count();
        $my_orders = Order::where('status', 3)->where('deliverer_id', Auth::user()->id)->count();
        return view('deliverer.index', compact('orders','d_count', 'order_count', 'my_orders'));
    }
}
