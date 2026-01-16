@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')
    <div class="container my-5">
        {{-- Alerts --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Breadcrumb + Heading --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active">Đơn hàng của tôi</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0"><i class="fa-solid fa-box-open me-2 text-primary"></i> Đơn hàng của tôi</h2>
            <div class="d-flex align-items-center">
                <form action="{{ route('orders.search') }}" method="GET" class="d-flex align-items-center">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm me-2" placeholder="Nhập mã đơn">
                    <select name="status" class="form-select form-select-sm me-2">
                        <option value="">Tất cả trạng thái</option>
                        <option value="0" {{ request('status')==='0'? 'selected':'' }}>Đang chờ xử lý</option>
                        <option value="1" {{ request('status')==='1'? 'selected':'' }}>Chờ thanh toán</option>
                        <option value="2" {{ request('status')==='2'? 'selected':'' }}>Đang giao hàng</option>
                        <option value="3" {{ request('status')==='3'? 'selected':'' }}>Đang giao</option>
                        <option value="4" {{ request('status')==='4'? 'selected':'' }}>Đã nhận</option>
                        <option value="-1" {{ request('status')==='-1'? 'selected':'' }}>Đã hủy</option>
                    </select>
                    <button class="btn btn-outline-primary btn-sm">Lọc</button>
                </form>
            </div>
        </div>

        {{-- Orders list --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0">Mã đơn</th>
                                <th class="border-0">Ngày đặt</th>
                                <th class="border-0">Trạng thái</th>
                                <th class="border-0 text-center">Số sản phẩm</th>
                                <th class="border-0 text-end">Tổng tiền</th>
                                <th class="border-0 text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td class="fw-semibold">#{{ $order->id }}</td>
                                    <td>
                                        <div class="small text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                                        @if($order->updated_at && $order->updated_at->ne($order->created_at))
                                            <div class="small text-muted">Cập nhật: {{ $order->updated_at->format('d/m/Y H:i') }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        @switch($order->status)
                                            @case(-1)
                                                <span class="badge bg-danger">Đã hủy</span>
                                            @break
                                            @case(0)
                                                <span class="badge bg-secondary">Đang chờ xử lý</span>
                                            @break
                                            @case(1)
                                                <span class="badge bg-warning">Chờ thanh toán</span>
                                            @break
                                            @case(2)
                                                <span class="badge bg-info text-dark">Đang giao hàng</span>
                                            @break
                                            @case(3)
                                                <span class="badge bg-primary">Đang giao</span>
                                            @break
                                            @case(4)
                                                <span class="badge bg-success">Đã nhận</span>
                                            @break
                                            @default
                                                <span class="badge bg-secondary">Không xác định</span>
                                        @endswitch
                                    </td>
                                    <td class="text-center">{{ $order_details->where('order_id', $order->id)->count('book_id') }}</td>
                                    <td class="text-end fw-bold">{{ number_format(ceil($order->total * 25000),0,',','.') }}đ</td>
                                    <td class="text-center">
                                        <a href="{{ route('orders.details', $order->id) }}" class="btn btn-sm btn-outline-primary me-1">Xem</a>

                                        @if(in_array($order->status, [0,1]))
                                            <!-- Cancel button triggers modal per order -->
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal-{{ $order->id }}">Hủy</button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="cancelModal-{{ $order->id }}" tabindex="-1" aria-labelledby="cancelModalLabel-{{ $order->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="cancelModalLabel-{{ $order->id }}">Hủy đơn #{{ $order->id }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Bạn có chắc muốn hủy đơn hàng này? Hành động này không thể hoàn tác.
                                                            <div class="mt-2 small text-muted">Số sản phẩm: {{ $order_details->where('order_id', $order->id)->count('book_id') }} — Tổng: {{ number_format(ceil($order->total * 25000),0,',','.') }}đ</div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="w-100">
                                                                @csrf
                                                                <input type="number" name="order_id" value="{{ $order->id }}" hidden>
                                                                <div class="d-flex gap-2 w-100">
                                                                    <button type="submit" class="btn btn-danger w-100">Xác nhận hủy</button>
                                                                    <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Đóng</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fa-regular fa-folder-open me-2"></i> Bạn chưa có đơn hàng nào.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Pagination + summary --}}
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                @if($orders->total() > 0)
                    <small class="text-muted">Hiển thị {{ $orders->firstItem() }}–{{ $orders->lastItem() }} trong {{ $orders->total() }} đơn hàng</small>
                @endif
            </div>
            <div>
                {{ $orders->withQueryString()->links() }}
            </div>
        </div>

    </div>
@endsection
