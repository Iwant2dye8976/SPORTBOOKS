<div id="alert-container" class="row"></div>
@if (session('success'))
    <div class="alert alert-success text-center" id="success-alert">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger text-center" id="error-alert">
        {{ session('error') }}
    </div>
@endif


<div class="row row-cols-auto mb-3">
    <div class="col-6 p-0">
        <form action="{{ route('delivery.orders-m.search') }}" method="GET">
            <div class="search-box">
                <button class="border border-0 bg-light" type="submit">
                    <i class="fa fa-search"></i>
                </button>
                <input class="form-control" type="search" name="keyword" placeholder="Tìm kiếm..."
                    value="{{ request('keyword') }}">
            </div>
        </form>
    </div>
</div>

<div class="row row-cols-auto" style="min-height:max-content;">
    <div class="col-12 border border-dark border-1 rounded"
        style="background-color: #fffaf0; max-height: 900px; overflow-y: auto;">
        <div class="row row-cols-2 mb-2 pb-4 pt-1 px-3 sticky-top" style="background-color: #fffaf0; z-index: 999;">
            <div class="col">
                <a href="{{ route('delivery.orders-m') }}"
                    class="text-start sticky-top fs-2 text-decoration-none text-dark">Đơn hàng đã nhận giao</a>
            </div>
            <div class="col mb-4">
                <h4 class="text-end text-secondary">{{ $order_count }} đơn hàng</h4>
            </div>
            <div class="col-12 mt-3">
                <hr>
            </div>
            <div class="col-2 text-center">
                Mã đơn hàng
            </div>
            <div class="col-3 text-center">
                Họ tên
            </div>
            <div class="col-3 text-center">
                Tổng tiền
            </div>
            <div class="col-2 text-center">
                Trạng thái
            </div>
            <div class="col-12">
                <hr>
            </div>
        </div>
        <div class="row row-cols-auto px-3">
            @foreach ($orders as $order)
                <div class="col-2 text-center align-self-center">
                    {{ $order->id }}
                </div>
                <div class="col-3 text-center align-self-center">
                    {{ $order->recipient_name }}
                </div>
                <div class="col-3 text-center fw-bold align-self-center">
                    {{ number_format(ceil($order->total * 25000), 0, ',', '.') }}đ
                </div>
                <div class="col-2 text-center align-self-center">
                    @switch($order->status)
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
                            <span class="text text-dark fw-bold">Trạng thái không xác định</span>
                    @endswitch
                </div>
                <div class="col-2 text-center align-self-center">
                    <a class="text text-decoration-none text-secondary fs-5"
                        href="{{ route('delivery.my-orders-detail', $order->id) }}">Chi tiết</a>
                </div>
                <div class="col-12 my-2">
                    <hr>
                </div>
            @endforeach
        </div>
    </div>
</div>
<div class="d-flex justify-content-center mt-4">
    {{ $orders->links('pagination::bootstrap-4') }}
</div>
