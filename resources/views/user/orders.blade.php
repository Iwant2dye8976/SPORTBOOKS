@extends('layouts.app')

@section('title', 'Đơn hàng')

@section('content')
    <div class="mt-5 border border-dark border-1 rounded p-3"
        style="background-color: #fffaf0; max-height: 900px; overflow-y: auto;">
        <div class="row row-cols-2 pb-4 pt-1 px-1 sticky-top" style="background-color: #fffaf0">
            <div class="col">
                <h2 class="text-start sticky-top">Đơn hàng</h2>
            </div>
            <div class="col mb-4">
                <h4 class="text-end text-secondary">{{ $order_count }} đơn hàng</h4>
            </div>
            <div class="col-12 mt-3">
                <hr>
            </div>
            <div class="col-4 text-center">
                Nội dung
            </div>
            <div class="col-3 text-center">
                Tổng tiền
            </div>
            <div class="col-3 text-center">
                Trạng thái
            </div>
            <div class="col-12">
                <hr>
            </div>
        </div>
        <div class="row row-cols-auto px-3 fs-5 d-flex">
            @foreach ($orders as $order)
                <div class="col-4 text-center align-items-center">
                    {{ $order->note }}
                </div>
                <div class="col-3 text-center fw-bold">
                    ${{ $order->total }}
                </div>
                <div class="col-3 text-center">
                    @switch($order->status)
                        @case(-1)
                            Chờ xử lý
                        @break

                        @case(0)
                            Đã hủy
                        @break

                        @case(1)
                            Đã hoàn thành
                        @break

                        @default
                            Trạng thái không xác định
                    @endswitch
                </div>
                <div class="col-2 text-center">
                    <a class="text text-decoration-none text-secondary"
                        href="{{ route('orders.details', $order->id) }}">Chi tiết</a>
                </div>
                <div class="col-12 my-2">
                    <hr>
                </div>
            @endforeach
        </div>
    </div>
@endsection
