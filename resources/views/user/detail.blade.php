@extends('layouts.app')

@section('title', 'Chi tiết sách')

@section('content')
    <div class="container my-5">
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
        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert" id="error-alert">
                <i class="fa-solid fa-exclamation-circle me-2"></i>
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active">Chi tiết sách</li>
            </ol>
        </nav>

        <!-- Thông tin chính sách -->
        <div class="row g-4">
            <!-- Ảnh sách -->
            <div class="col-12 col-lg-5">
                <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-body p-4 text-center"
                        style="background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);">
                        <img src="{{ $book->image_url }}" alt="{{ $book->title }}" class="img-fluid rounded"
                            style="max-height: 500px; object-fit: contain;">
                    </div>
                    @if (isset($book->discount) && $book->discount > 0)
                        <span class="position-absolute top-0 end-0 badge bg-danger m-2">
                            -{{ $book->discount }}%
                        </span>
                    @endif
                </div>
            </div>

            <!-- Thông tin sách -->
            <div class="col-12 col-lg-7">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <!-- Tiêu đề -->
                        <h2 class="fw-bold mb-3" style="color: #2d3748;">{{ $book->title }}</h2>

                        <!-- Đánh giá sao -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="text-warning me-2">
                                {{-- <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star-half-stroke"></i> --}}
                            </div>
                            <span class="text-muted">(<i class="fa-solid fa-star text-warning"></i>
                                {{ number_format($book->bookreviews->avg('rating') ?? 0, 1) }}/5.0 -
                                {{ $book->bookreviews->count() ?? 0 }} đánh giá)</span>
                        </div>

                        <!-- Giá -->
                        <div class="mb-4 p-3 rounded" style="background-color: #fff5f5;">
                            <div class="d-flex-row align-items-center">
                                @if (isset($book->origin_price))
                                    @if (isset($book->discount) && $book->discount > 0)
                                        <p class="text-muted text-decoration-line-through fs-5 mb-0">
                                            {{ number_format($book->origin_price * 25000, 0, ',', '.') }}đ
                                        </p>

                                        <p class="text-danger fw-bold fs-3 mb-0">
                                            {{ number_format(ceil($book->final_price * 25000), 0, ',', '.') }}đ
                                            <span
                                                class="badge bg-danger ms-2 text-center fs-5">-{{ $book->discount }}%</span>
                                        </p>
                                    @else
                                        <p class="text-danger fw-bold fs-3 mb-0">
                                            {{ number_format($book->final_price * 25000, 0, ',', '.') }}đ
                                        </p>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <!-- Thông tin tác giả -->
                        <div class="mb-4">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-user-pen text-primary me-2 fs-5"></i>
                                        <div>
                                            <small class="text-muted d-block">Tác giả</small>
                                            <strong>{{ $book->author }}</strong>
                                        </div>
                                    </div>
                                </div>
                                @if (isset($book->publisher))
                                    <div class="col-12 col-md-6">
                                        <div class="d-flex align-items-center">
                                            <i class="fa-solid fa-building text-primary me-2 fs-5"></i>
                                            <div>
                                                <small class="text-muted d-block">Nhà xuất bản</small>
                                                <strong>{{ $book->publisher }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Form mua hàng -->
                        <form method="POST" action="{{ route('cart.add', $book->id) }}" onsubmit="disableButton()">
                            @csrf
                            <div class="mb-4">
                                <i class="fa-solid fa-book-open me-1"></i>
                                Tồn kho: <strong>{{ $book->stock }} cuốn</strong>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold mb-2" for="amount">
                                    <i class="fa-solid fa-calculator me-1"></i>
                                    Số lượng
                                </label>
                                <div class="input-group" style="width: 150px;">
                                    <button class="btn btn-outline-secondary" type="button" onclick="decreaseAmount()">
                                        <i class="fa-solid fa-minus"></i>
                                    </button>
                                    <input id="amount" type="number" name="amount" class="form-control text-center"
                                        value="1" min="1" max="999" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="increaseAmount()">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex gap-2 flex-wrap">
                                <button id="submit-button" type="submit" class="btn btn-outline-primary btn-lg px-4">
                                    <i class="fa-solid fa-cart-plus me-2"></i>
                                    Thêm vào giỏ hàng
                                </button>
                                <a class="btn btn-primary btn-lg px-4" href="{{ route('buynow-v', $book->id) }}">
                                    <i class="fa-solid fa-bolt me-2"></i>
                                    Mua ngay
                                </a>
                            </div>
                        </form>

                        <!-- Chính sách -->
                        <div class="mt-4 pt-4 border-top">
                            <div class="row g-3">
                                <div class="col-6 col-md-3">
                                    <div class="text-center">
                                        <i class="fa-solid fa-truck-fast text-primary fs-3 mb-2"></i>
                                        <p class="small mb-0">Giao hàng nhanh</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="text-center">
                                        <i class="fa-solid fa-shield text-success fs-3 mb-2"></i>
                                        <p class="small mb-0">Hàng chính hãng</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="text-center">
                                        <i class="fa-solid fa-rotate-left text-info fs-3 mb-2"></i>
                                        <p class="small mb-0">Đổi trả 7 ngày</p>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="text-center">
                                        <i class="fa-solid fa-headset text-warning fs-3 mb-2"></i>
                                        <p class="small mb-0">Hỗ trợ 24/7</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                @include('components.book-review')
            </div>
            <div class="mb-4">
                @include('components.book-related')
            </div>
        </div>
    </div>
@endsection
