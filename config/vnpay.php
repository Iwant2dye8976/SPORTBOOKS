<?php

return [

    /*
    |--------------------------------------------------------------------------
    | VNPAY Configuration
    |--------------------------------------------------------------------------
    |
    | Thông tin cấu hình cho tích hợp VNPAY.
    |
    */

    'tmn_code' => env('VNP_TMN_CODE', ''),         // Mã Website của bạn tại VNPAY
    'hash_secret' => env('VNP_HASH_SECRET', ''),   // Chuỗi bí mật dùng để tạo chữ ký
    'url' => env('VNP_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html'), // URL thanh toán
    'return_url' => env('VNP_RETURN_URL', ''),     // URL để VNPAY redirect sau khi thanh toán
    'version' => '2.1.0',
    'command' => 'pay',
    'curr_code' => 'VND',
    'locale' => 'vn',
    'order_type' => 'billpayment',

];
