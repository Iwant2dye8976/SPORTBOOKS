{{-- @extends('layouts.app')

@section('title', 'Đơn hàng')

@section('content')
        <div class="row alert alert-success text-center" id="success-alert" style="display: none;">
            Thanh toán thành công.
        </div>

        <div class="row alert alert-danger text-center" id="error-alert" style="display: none;">
            Thanh toán thất bại.
        </div>

    <div class="mt-2 row border border-dark border-1 rounded"
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
                    ${{ $order->total }}
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
                            <span class="text text-success fw-bold">Đã xác nhận</span>
                        @break

                        @default
                            <span class="text text-dark fw-bold">Trạng thái không xác định</span>
                    @endswitch
                </div>
                <div class="col-1 text-center">
                    <a class="text text-decoration-none text-secondary"
                        href="{{ route('admin.order-detail', $order->id) }}">Chi
                        tiết</a>
                </div>
                <div class="col-12 my-2">
                    <hr>
                </div>
            @endforeach
        </div>
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links('pagination::bootstrap-4') }}
    </div>
    <script>
        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        window.onload = function() {
            let success_alert = document.getElementById('success-alert');
            let fail_alert = document.getElementById('error-alert');
            let vnpay_status = getQueryParam('vnp_TransactionStatus');

            if (vnpay_status === '00' && success_alert) {
                success_alert.style.display = "block";
            }

            if (vnpay_status === '02' && fail_alert) {
                fail_alert.style.display = "block";
            }
        };
    </script>
@endsection --}}
