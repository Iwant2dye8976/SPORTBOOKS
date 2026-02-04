@if (session('success'))
    <div class="alert alert-success text-center" id="success-alert">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger text-center" id="error-alert">{{ session('error') }}</div>
@endif

<div class="mb-4">
    <h2 class="fw-bold">Quản lý đơn hàng</h2>
    <p class="text-muted">{{ $order_count }} đơn hàng</p>
</div>

<div class="table-responsive border rounded bg-light p-3 shadow-sm">
    <table class="table table-bordered align-middle mb-0">
        <thead class="table-secondary">
            <tr class="text-center">
                <th scope="col">Mã đơn</th>
                <th scope="col">Họ tên</th>
                <th scope="col">Tổng tiền</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr class="text-center">
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->recipient_name }}</td>
                    <td class="fw-bold text-success">{{ number_format(ceil($order->total * 25000), 0, ',', '.') }}đ</td>
                    <td>
                        @switch($order->status)
                            @case(-1) <span class="badge bg-warning text-dark">Chờ xử lý</span> @break
                            @case(0) <span class="badge bg-danger">Đã hủy</span> @break
                            @case(1) <span class="badge bg-warning text-dark">Chờ thanh toán</span> @break
                            @case(2) <span class="badge bg-info text-dark">Chờ giao hàng</span> @break
                            @case(3) <span class="badge bg-primary">Đang giao hàng</span> @break
                            @case(4) <span class="badge bg-success">Đã nhận hàng</span> @break
                            @default <span class="badge bg-secondary">Không xác định</span>
                        @endswitch
                    </td>
                    <td>
                        <a href="{{ route('admin.order-m.detail', $order->id) }}" class="btn btn-sm btn-outline-secondary">
                            Xem chi tiết
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Không có đơn hàng nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $orders->links('pagination::bootstrap-4') }}
</div>
