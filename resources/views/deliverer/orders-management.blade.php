<div class="mt-5 mb-5">
    <div id="alert-container" class="row"></div>
    {{-- @if (session('success'))
        <div class="alert alert-success text-center" id="success-alert">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger text-center" id="error-alert">
            {{ session('error') }}
        </div>
    @endif --}}
    <div class="row row-cols-auto" style="min-height:max-content;">
        <div class="col-12 border border-dark border-1 rounded"
            style="background-color: #fffaf0; max-height: 900px; overflow-y: auto;">
            <div class="row row-cols-2 mb-4 pb-4 pt-1 px-1 sticky-top" style="background-color: #fffaf0; z-index: 999;">
                <div class="col">
                    <a href="{{ route('delivery.orders-m') }}"
                        class="text-start sticky-top fs-2 text-decoration-none text-dark">Quản lý đơn hàng</a>
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
                <div class="col-2 text-center">
                    Tổng tiền
                </div>
                <div class="col-3 text-center">
                    Trạng thái
                </div>
                <div class="col-12">
                    <hr>
                </div>
            </div>
            <div class="row row-cols-auto px-3">
                @foreach ($orders as $order)
                    <div class="col-2 text-center">
                        {{ $order->id }}
                    </div>
                    <div class="col-3 text-center">
                        {{ $order->recipient_name }}
                    </div>
                    <div class="col-2 text-center fw-bold">
                        ${{ $order->total }}
                    </div>
                    {{-- <div class="col-3 d-flex justify-content-center h-50">
                        <select name="status" id="order-status-{{ $order->id }}" class="form-select w-50"
                            onblur="updateOrder({{ $order->id }});">
                            <option value="-1" {{ $order->status == -1 ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="0" {{ $order->status == 0 ? 'selected' : '' }}>Hủy</option>
                            <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>Đã xác nhận</option>
                        </select>
                    </div> --}}
                    <div class="col-3 text-center">
                        @switch($order->status)
                            @case(-1)
                                <span class="text text-warning fw-bold">Chờ xử lý</span>
                            @break

                            @case(0)
                                <span class="text text-danger fw-bold">Đã hủy</span>
                            @break

                            @case(1)
                                <span class="text text-primary fw-bold">Chờ thanh toán</span>
                            @break

                            @default
                                <span class="text text-dark fw-bold">Trạng thái không xác định</span>
                        @endswitch
                    </div>
                    <div class="col-2 text-center">
                        <a class="text text-decoration-none text-secondary fs-5"
                            href="">Chi tiết</a>
                    </div>
                    <div class="col-12 my-2">
                        <hr>
                    </div>
                @endforeach
            </div>
        </div>

        <script>
            function updateOrder(orderId) {
                let statusOption = document.getElementById("order-status-" + orderId);
                let orderStatus = parseInt(statusOption.value, 10);

                fetch(`/admin/order/update`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: JSON.stringify({
                            id: orderId,
                            status: orderStatus
                        })
                    }).then(response => response.json())
                    .then(data => {
    if (data.success) {
        showBootstrapAlert(data.message, 'success');
        console.log("Cập nhật thành công:", data.order);
    } else {
        showBootstrapAlert(data.message, 'danger');
    }
})
.catch(error => {
    showBootstrapAlert("Có lỗi xảy ra khi cập nhật đơn hàng.", 'danger');
    console.error(error);
});
            }
        </script>
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links('pagination::bootstrap-4') }}
    </div>
</div>
