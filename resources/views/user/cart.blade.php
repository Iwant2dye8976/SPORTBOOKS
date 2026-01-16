@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
    <div class="container my-5">
        <!-- Alerts -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" id="success-alert">
                <i class="fa-solid fa-circle-check me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" id="error-alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active">Giỏ hàng</li>
            </ol>
        </nav>

        <!-- Tiêu đề -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="fa-solid fa-cart-shopping me-2 text-primary"></i>
                Giỏ hàng của bạn
            </h2>
            @if ($cart_count > 0)
                <span class="badge bg-primary rounded-pill fs-6">{{ $cart_count }} sản phẩm</span>
            @endif
        </div>

        @if ($cart_count === 0)
            <!-- Giỏ hàng trống -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fa-solid fa-cart-shopping text-muted" style="font-size: 100px; opacity: 0.3;"></i>
                </div>
                <h3 class="text-muted mb-3">Giỏ hàng trống</h3>
                <p class="text-muted mb-4">Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm</p>
                <a href="{{ route('home') }}" class="btn btn-primary btn-lg px-5">
                    <i class="fa-solid fa-arrow-left me-2"></i>
                    Tiếp tục mua sắm
                </a>
            </div>
        @else
            <div class="row g-4">
                <!-- Danh sách sản phẩm -->
                <div class="col-12 col-lg-9">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 fw-semibold">Sản phẩm trong giỏ</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0 ps-4" style="width: 100px;">Ảnh</th>
                                            <th class="border-0">Sản phẩm</th>
                                            <th class="border-0 text-center" style="width: 150px;">Đơn giá</th>
                                            <th class="border-0 text-center" style="width: 180px;">Số lượng</th>
                                            <th class="border-0 text-center" style="width: 150px;">Thành tiền</th>
                                            <th class="border-0 text-center" style="width: 80px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartItems as $item)
                                            <tr class="book-item">
                                                <td class="ps-4">
                                                    <a href="{{ route('detail', $item->book->id) }}">
                                                        <img src="{{ $item->book->image_url }}"
                                                            alt="{{ $item->book->title }}"
                                                            class="img-fluid rounded shadow-sm"
                                                            style="width: 70px; height: 90px; object-fit: cover;">
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('detail', $item->book->id) }}"
                                                        class="text-decoration-none text-dark">
                                                        <h6 class="mb-1 fw-semibold">{{ $item->book->title }}</h6>
                                                    </a>
                                                    @if (isset($item->book->author))
                                                        <small class="text-muted">
                                                            <i class="fa-solid fa-user-pen me-1"></i>
                                                            {{ $item->book->author }}
                                                        </small>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <span class="text-danger fw-bold">
                                                        @if (isset($item->book->origin_price))
                                                            @if (isset($item->book->discount) && $item->book->discount > 0)
                                                                <p
                                                                    class="text-muted text-decoration-line-through small mb-0">
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
                                                        {{-- {{ number_format(ceil($item->book->price * 25000), 0, ',', '.') }}đ --}}
                                                    </span>
                                                    <input class="book-price" type="number" step="0.01"
                                                        value="{{ $item->book->final_price }}"
                                                        id="price-{{ $item->book->id }}" hidden>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center align-items-center">
                                                        <div class="input-group" style="max-width: 140px;">
                                                            <button class="btn btn-outline-secondary btn-sm" type="button"
                                                                onclick="decreaseQuantity({{ $item->book->id }})">
                                                                <i class="fa-solid fa-minus"></i>
                                                            </button>
                                                            <input type="number"
                                                                class="form-control form-control-sm text-center book-quantity"
                                                                min="1" max="50"
                                                                value="{{ $item->book_quantity }}"
                                                                id="quantity-{{ $item->book->id }}"
                                                                onblur="updateCart({{ $item->book->id }})">
                                                            <button class="btn btn-outline-secondary btn-sm" type="button"
                                                                onclick="increaseQuantity({{ $item->book->id }})">
                                                                <i class="fa-solid fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span id="items-total-price-{{ $item->book->id }}"
                                                        class="fw-bold text-primary item-total">
                                                        {{ number_format(ceil($item->book->final_price * $item->book_quantity * 25000), 0, ',', '.') }}đ
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            title="Xóa sản phẩm"
                                                            onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                                            <i class="fa-solid fa-trash-can"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                                    <i class="fa-solid fa-arrow-left me-2"></i>
                                    Tiếp tục mua sắm
                                </a>
                                <form action="{{ route('cart.clear') }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-outline-danger" type="submit">
                                        <i class="fa-solid fa-trash-can me-2"></i>
                                        Xóa tất cả
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thông tin đặt hàng -->
                <div class="col-12 col-lg-3">
                    <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0 fw-semibold">
                                <i class="fa-solid fa-file-invoice me-2"></i>
                                Thông tin đặt hàng
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('checkout') }}" onsubmit="disableButton()">
                                @csrf

                                <!-- Thông tin người nhận -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" for="recipient_name">
                                        <i class="fa-solid fa-user me-1"></i>
                                        Họ và tên
                                    </label>
                                    <input class="form-control" type="text" name="recipient_name" id="recipient_name"
                                        value="{{ $user->name }}" required>
                                    @error('recipient_name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold" for="shipping_address">
                                        <i class="fa-solid fa-location-dot me-1"></i>
                                        Địa chỉ nhận hàng
                                    </label>
                                    <input class="form-control" type="text" name="shipping_address"
                                        id="shipping_address" value="{{ $user->address }}" required>
                                    @error('shipping_address')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold" for="phone_number">
                                        <i class="fa-solid fa-phone me-1"></i>
                                        Số điện thoại
                                    </label>
                                    <input class="form-control" type="tel" name="phone_number" id="phone_number"
                                        value="{{ $user->phone_number }}" required>
                                    @error('phone_number')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold" for="note">
                                        <i class="fa-solid fa-note-sticky me-1"></i>
                                        Ghi chú
                                    </label>
                                    <textarea class="form-control" name="note" id="note" rows="3" placeholder="Nhập ghi chú (nếu có)..."></textarea>
                                    @error('note')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold" for="shipping">
                                        <i class="fa-solid fa-truck-fast me-1"></i>
                                        Phương thức vận chuyển
                                    </label>
                                    <select name="shipping" id="shipping" class="form-select"
                                        onchange="updateTotalPrice()">
                                        <option value="0.6" data-fee="0.6">Tiết kiệm - 15.000đ</option>
                                        <option value="1.2" data-fee="1.2">Tiêu chuẩn - 30.000đ</option>
                                        <option value="2" data-fee="2">Nhanh - 50.000đ</option>
                                        <option value="4" data-fee="4">Hỏa tốc - 100.000đ</option>
                                    </select>
                                </div>

                                <hr class="my-4">

                                <!-- Chi tiết thanh toán -->
                                <h6 class="fw-bold mb-3">Chi tiết thanh toán</h6>

                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Tạm tính:</span>
                                    <span class="fw-semibold" id="book-price-detail">
                                        {{ number_format(ceil($total_price * 25000), 0, ',', '.') }}đ
                                    </span>
                                </div>
                                <input name="books-price" id="book-price-detail-i" type="number" step="0.01"
                                    value="{{ number_format($total_price, 2) }}" hidden>

                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Phí vận chuyển:</span>
                                    <span class="fw-semibold text-success" id="shipping-fee">15.000đ</span>
                                </div>

                                <hr class="my-3">

                                <div class="d-flex justify-content-between mb-4">
                                    <h5 class="fw-bold mb-0">Tổng cộng:</h5>
                                    <h5 class="fw-bold mb-0 text-danger total-price">
                                        {{ number_format(ceil($total_price * 25000), 0, ',', '.') }}đ
                                    </h5>
                                </div>
                                <input name="total-price" id="total-price" class="total-price" type="number"
                                    step="0.01" value="{{ $total_price }}" hidden>

                                <button id="submit-button" class="btn btn-primary btn-lg w-100" type="submit">
                                    <i class="fa-solid fa-check-circle me-2"></i>
                                    Đặt hàng ngay
                                </button>

                                <!-- Phương thức thanh toán -->
                                <div class="mt-3 p-3 bg-light rounded">
                                    <small class="text-muted d-block mb-2">
                                        <i class="fa-solid fa-shield-halved me-1"></i>
                                        Chúng tôi hỗ trợ:
                                    </small>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <span class="badge bg-white text-dark border">
                                            <i class="fa-solid fa-money-bill-wave me-1"></i>COD
                                        </span>
                                        <span class="badge bg-white text-dark border">
                                            <i class="fa-brands fa-cc-visa me-1"></i>Visa
                                        </span>
                                        <span class="badge bg-white text-dark border">
                                            <i class="fa-brands fa-cc-mastercard me-1"></i>Mastercard
                                        </span>
                                        <span class="badge bg-white text-dark border">
                                            <i class="fa-solid fa-wallet me-1"></i>Ví điện tử
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Khuyến mãi -->
                    <div class="card border-0 shadow-sm mt-3">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">
                                <i class="fa-solid fa-gift text-danger me-2"></i>
                                Ưu đãi đặc biệt
                            </h6>
                            <div class="alert alert-info mb-0">
                                <small>
                                    <i class="fa-solid fa-circle-info me-1"></i>
                                    Miễn phí vận chuyển cho đơn hàng trên 500.000đ
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
