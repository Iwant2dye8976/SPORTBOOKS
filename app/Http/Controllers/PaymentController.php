<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;

class PaymentController extends Controller
{
    public function handleVnpayReturn(Request $request, $id)
    {
        $vnp_HashSecret = config('vnpay.hash_secret');
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        $cart_count = 0;
        $order_count = 0;

        if (Auth::check()) {
            $userId = Auth::id();
            $cart_count = Cart::where('user_id', $userId)->count();
            $order_count = Order::where('user_id', $userId)
                ->count();
        }

        if (hash_equals($secureHash, $vnp_SecureHash)) {
            if ($request->query('vnp_ResponseCode') === '00') {
                // TODO: Cập nhật trạng thái đơn hàng thành thanh toán thành công
                $order = Order::where('id', $id)->first();
                $order->status = 2; // status = 2: Thanh toán thành công
                $order->save();
                return view('payment.success', compact('cart_count', 'order_count'));
            } else {
                return view('payment.failed', [
                    'message' => 'Thanh toán thất bại. Mã lỗi: ' . $request->query('vnp_ResponseCode'),
                    'cart_count' => $cart_count,
                    'order_count' => $order_count,
                ]);
            }
        } else {
            return view('payment.failed', [
                'message' => 'Chữ ký không hợp lệ.',
                'cart_count' => $cart_count,
                'order_count' => $order_count,
                // 'vnp_HashSecret' => $vnp_HashSecret,
                // 'vnp_SecureHash' => $vnp_SecureHash,
                // 'secureHash' => $secureHash,
                // 'inputData' => $inputData
            ]);
        }
    }
}
