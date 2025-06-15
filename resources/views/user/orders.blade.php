@extends('layouts.app')

@section('title', 'Đơn hàng')

@section('content')
    {{-- <div id="alert-container" class="row"></div> --}}
    @if (session('success'))
        <div class="row alert alert-success text-center" id="success-alert">
            <p class="p-0 m-0">{{ session('success') }}</p>
        </div>
    @endif
    <div class="mt-5 row border border-dark border-1 rounded mb-5"
        style="background-color: #fffaf0; max-height: 900px; overflow-y: auto;">
        <div class="row row-cols-2 mb-4 pb-4 pt-1 px-3 sticky-top" style="background-color: #fffaf0; z-index: 999;">
            <div class="col">
                <h2 class="text-start sticky-top">Đơn hàng</h2>
            </div>
            <div class="col mb-4">
                <h4 class="text-end text-secondary">{{ $order_count }} đơn hàng</h4>
            </div>
            <div class="col-12 mt-3">
                <hr>
            </div>
            <div class="col-3 text-center">
                Họ tên
            </div>
            <div class="col-3 text-center">
                Số điện thoại
            </div>
            <div class="col-2 text-center">
                Tổng tiền
            </div>
            <div class="col-2 text-center">
                Trạng thái
            </div>
            <div class="col-12">
                <hr>
            </div>
        </div>
        <div class="row row-cols-auto px-3 fs-5 d-flex">
            @foreach ($orders as $order)
                <div class="col-3 text-center align-items-center">
                    {{ $order->recipient_name }}
                </div>
                <div class="col-3 text-center align-items-center">
                    {{ $order->phone_number }}
                </div>
                <div class="col-2 text-center fw-bold">
                    {{ number_format(ceil($order->total * 25000), 0, ',', '.') . 'đ' }}
                </div>
                <div class="col-2 text-center">
                    @switch($order->status)
                        @case(-1)
                            <span class="text text-warning fw-bold">Chờ xử lý</span>
                        @break

                        @case(0)
                            <span class="text text-danger fw-bold">Đã hủy</span>
                        @break

                        @case(1)
                            <span class="text text-warning fw-bold">Chờ thanh toán</span>
                        @break

                        @case(2)
                            <span class="text text-warning fw-bold">Chờ giao hàng</span>
                        @break

                        @case(3)
                            <span class="text text-warning fw-bold">Đang giao hàng</span>
                        @break

                        @case(4)
                            <span class="text text-success fw-bold">Đã nhận hàng</span>
                        @break

                        @default
                            <span class="text text-primary fw-bold">Trạng thái không xác định</span>
                    @endswitch
                </div>
                <div class="col-2 text-center">
                    <a class="text text-decoration-none text-secondary" href="{{ route('orders.details', $order->id) }}">Chi
                        tiết</a>
                </div>
                <div class="col-12 my-2">
                    <hr>
                </div>
            @endforeach
        </div>
    </div>
@endsection
