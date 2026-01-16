@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng')

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

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('orders') }}">Đơn hàng của tôi</a></li>
                <li class="breadcrumb-item active">Chi tiết đơn hàng</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="fa-solid fa-receipt me-2 text-primary"></i>
                Chi tiết đơn hàng #{{ $order_information->id }}
            </h2>
            <div>
                <span
                    class="badge bg-primary rounded-pill fs-6">{{ number_format(ceil($order_information->total * 25000), 0, ',', '.') }}đ</span>
                <small class="text-muted ms-2">({{ $order_details->count() }} sản phẩm)</small>
            </div>
        </div>

        <div class="row g-4">
            {{-- Order items --}}
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-semibold">Sản phẩm trong đơn</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0 ps-4" style="width: 100px;">Ảnh</th>
                                        <th class="border-0">Sản phẩm</th>
                                        <th class="border-0 text-center" style="width: 120px;">Số lượng</th>
                                        <th class="border-0 text-center" style="width: 150px;">Đơn giá</th>
                                        <th class="border-0 text-center" style="width: 150px;">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order_details as $item)
                                        <tr>
                                            <td class="ps-4">
                                                <a href="{{ route('detail', $item->book->id) }}">
                                                    <img src="{{ $item->book->image_url }}" alt="{{ $item->book->title }}"
                                                        class="img-fluid rounded shadow-sm"
                                                        style="width:70px;height:90px;object-fit:cover;">
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('detail', $item->book->id) }}"
                                                    class="text-decoration-none text-dark">
                                                    <h6 class="mb-1 fw-semibold">{{ $item->book->title }}</h6>
                                                </a>
                                                @if (isset($item->book->author))
                                                    <small class="text-muted"><i class="fa-solid fa-user-pen me-1"></i>
                                                        {{ $item->book->author }}</small>
                                                @endif
                                            </td>
                                            <td class="text-center fw-semibold">{{ $item->book_quantity }}</td>
                                            <td class="text-center">
                                                @if (isset($item->book->origin_price))
                                                    @if (isset($item->book->discount) && $item->book->discount > 0)
                                                        <p class="text-muted text-decoration-line-through small mb-0">
                                                            {{ number_format($item->book->origin_price * 25000, 0, ',', '.') }}đ
                                                        </p>

                                                        <p class="text-danger fw-bold small mb-0">
                                                            {{ number_format(ceil($item->book->final_price * 25000), 0, ',', '.') }}đ
                                                            <span
                                                                class="badge bg-danger ms-2 text-center small">-{{ $item->book->discount }}%</span>
                                                        </p>
                                                    @else
                                                        <p class="text-danger fw-bold small mb-0">
                                                            {{ number_format($item->book->final_price * 25000, 0, ',', '.') }}đ
                                                        </p>
                                                    @endif
                                                @endif
                                                {{-- <span class="fw-bold text-danger">{{ number_format(ceil($item->book->final_price * 25000),0,',','.') }}đ</span> --}}
                                            </td>
                                            <td class="text-center fw-bold">
                                                {{ number_format(ceil($item->book->final_price * $item->book_quantity * 25000), 0, ',', '.') }}đ
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Order timeline / status card --}}
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body">
                        <h5 class="fw-semibold">Trạng thái đơn hàng</h5>
                        <p class="mb-2">
                            @switch($order_information->status)
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
                        </p>
                        {{-- @if ($order_information->status == -1)
                            <p class="text-muted">Đơn hàng đã được hủy vào
                                {{ $order_information->updated_at->format('d/m/Y H:i') }}</p>
                        @endif --}}
                    </div>
                </div>
            </div>

            {{-- Summary & customer info --}}
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-semibold">Thông tin đặt hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small">Họ và tên</label>
                            <input class="form-control-plaintext fw-bold" readonly
                                value="{{ $order_information->recipient_name }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Địa chỉ nhận hàng</label>
                            <div class="form-control-plaintext text-break">{{ $order_information->shipping_address }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Số điện thoại</label>
                            <div class="form-control-plaintext">{{ $order_information->phone_number }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Ghi chú</label>
                            <div class="form-control-plaintext text-muted">{{ $order_information->note ?? '-' }}</div>
                        </div>

                        <hr>
                        <h6 class="fw-semibold">Chi tiết thanh toán</h6>
                        <div class="d-flex justify-content-between">
                            <div>Tiền sách</div>
                            <div>{{ number_format(ceil($order_information->books_price * 25000), 0, ',', '.') }}đ</div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>Phí vận chuyển</div>
                            <div>{{ number_format(ceil($order_information->shipping_fee * 25000), 0, ',', '.') }}đ</div>
                        </div>
                        <div class="d-flex justify-content-between fw-bold mt-2">
                            <div>Tổng</div>
                            <div>{{ number_format(ceil($order_information->total * 25000), 0, ',', '.') }}đ</div>
                        </div>

                        @switch($order_information->status)
                            @case(-1)
                                {{-- cancelled --}}
                            @break

                            @case(1)
                                <form action="{{ route('checkout.vnpay', $order_information->id) }}" method="POST" class="mt-3">
                                    @csrf
                                    <input name="total_price" type="number" value="{{ ceil($order_information->total * 25000) }}"
                                        hidden>
                                    <input type="number" name="order_id" value="{{ $order_information->id }}" hidden>
                                    <label class="form-label small" for="payment_method">Phương thức thanh toán</label>
                                    <select name="payment_method" id="payment_method" class="form-select mb-3">
                                        <option value="cod">Thanh toán khi nhận hàng</option>
                                        <option value="vnpay">VN Pay</option>
                                    </select>
                                    <button class="btn btn-primary w-100">THANH TOÁN</button>
                                </form>
                            @break

                            @default
                                {{-- no action --}}
                        @endswitch

                    </div>
                </div>

                {{-- Actions: Cancel if possible --}}
                @if ($order_information->status == -1)
                    {{-- already cancelled --}}
                @elseif($order_information->status == 0 || $order_information->status == 1)
                    <div class="mt-3">
                        <form action="{{ route('orders.cancel', $order_information->id) }}" method="POST"
                            onsubmit="disableButton();">
                            @csrf
                            <input type="number" value="{{ $order_information->id }}" name="order_id" hidden>
                            <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal"
                                data-bs-target="#cancelModal">HỦY ĐƠN</button>

                            <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="cancelModalLabel">Hủy đơn hàng</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có chắc muốn <strong class="text-danger">hủy đơn hàng này?</strong>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger">Xác nhận</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Hủy</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
