<div class="mt-5">
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
    <div class="row row-cols-auto" style="min-height:max-content;">
        <div class="col-12 border border-dark border-1 rounded"
            style="background-color: #fffaf0; max-height: 900px; overflow-y: auto;">
            <div class="row row-cols-2 mb-4 pb-4 pt-1 px-1 sticky-top" style="background-color: #fffaf0">
                <div class="col">
                    <h2 class="text-start sticky-top">Quản lý đơn hàng</h2>
                </div>
                <div class="col mb-4">
                    <h4 class="text-end text-secondary">{{ $orders->count() }} đơn hàng</h4>
                </div>
                <div class="col-12 mt-3">
                    <hr>
                </div>
                <div class="col-2 text-center">
                    Mã đơn hàng
                </div>
                <div class="col-4 text-center">
                    Nội dung
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
                    <div class="col-4 text-center">
                        {{ $order->note }}
                    </div>
                    <div class="col-2 text-center fw-bold">
                        ${{ $order->total }}
                    </div>
                    <div class="col-3 d-flex justify-content-center h-50">
                        <select name="status" id="order-status-{{ $order->id }}" class="form-select w-50"
                            onblur="updateOrder({{ $order->id }});">
                            <option value="-1" {{ $order->status == -1 ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="0" {{ $order->status == 0 ? 'selected' : '' }}>Hủy</option>
                            <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>Đã xác nhận</option>
                        </select>
                    </div>
                    <div class="col-1 text-center">
                        <a class="text text-decoration-none text-secondary fs-5"
                            href="{{ route('admin.order-detail', $order->id) }}">Chi tiết</a>
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
                            console.log("Cập nhật đơn hàng thành công");
                        }
                    }).catch(error => console.error("Lỗi cập nhật đơn hàng:", error));
            }

            setTimeout(function() {
                let alert = document.getElementById('success-alert');
                let e_alert = document.getElementById('error-alert');
                if (alert) {
                    alert.style.transition = "opacity 0.5s ease";
                    alert.style.opacity = "0";
                    setTimeout(() => alert.remove(), 500);
                }
                if (e_alert) {
                    e_alert.style.transition = "opacity 0.5s ease";
                    e_alert.style.opacity = "0";
                    setTimeout(() => e_alert.remove(), 500);
                }
            }, 3000);
        </script>
    </div>
</div>
