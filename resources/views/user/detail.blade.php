@extends('layouts.app')

@section('title', 'Chi tiết sách')

{{-- @section('banner')
    <img class="img-fluid" src="{{ asset('imgs/tc-banner-t5.png') }}" alt="Banner">
@endsection --}}



@section('content')
    {{-- <style>
        .book-img img {
            max-width: 100%;
            height: 300px;
            object-fit: fill;
            object-position: center;
            border-radius: 10px;
        }
    </style> --}}
    @if (session('error'))
        <div class="container-fluid alert alert-danger text-center" id="error-alert">
            <p class="p-0 m-0">{{ session('error') }}</p>
        </div>
    @endif
    @if (session('warning'))
        <div class="container-fluid alert alert-warning text-center" id="error-alert">
            <p class="p-0 m-0">{{ session('warning') }}</p>
        </div>
    @endif
    @if (session('success'))
        <div class="container-fluid row alert alert-success text-center" id="success-alert">
            <p class="p-0 m-0">{{ session('success') }}</p>
        </div>
    @endif
    <div class="container my-5">
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
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star-half-stroke"></i>
                            </div>
                            <span class="text-muted">(4.5/5 - 128 đánh giá)</span>
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
                                            <span class="badge bg-danger ms-2 text-center fs-5">-{{ $book->discount }}%</span>
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
            <div>
                @include('components.book-review')
            </div>
        </div>
    </div>
@endsection
