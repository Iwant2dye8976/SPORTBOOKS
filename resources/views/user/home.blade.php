@extends('layouts.app')

@section('title', 'Trang Chủ')

@section('banner')
    <div class="position-relative overflow-hidden">
        <img class="img-fluid w-100" src="{{ asset('imgs/banner-2.png') }}" alt="Banner"
            style="height: 240px; object-fit: cover;">
        {{-- <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.3);">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bold mb-3">Khám Phá Thế Giới Sách</h1>
                <p class="lead">Hàng ngàn đầu sách chất lượng đang chờ bạn</p>
            </div>
        </div> --}}
    </div>
@endsection

@section('content')
    <div class="container py-4">
        @if (request()->query('verified') == 1)
            <div id="success-alert" class="alert alert-success alert-dismissible fade show text-center shadow-sm"
                role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>
                Email của bạn đã được xác minh thành công!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
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

        <!-- Bộ lọc danh mục -->
        <div class="card shadow-md mb-4 border-0">
            <div class="card-body" style="background: #6594B1;">
                <div class="d-flex align-items-center mb-3">
                    <i class="fa-solid fa-filter text-white fs-4 me-2"></i>
                    <h4 class="text-white mb-0 fw-bold">Danh Mục Sách</h4>
                </div>

                <form action="{{ route('filter') }}" method="GET">
                    <input type="hidden" name="keyword" value="{{ rawurldecode(request('keyword')) }}">

                    <div class="row g-2">
                        <div class="col-6 col-md-4 col-lg-2">
                            <button
                                class="btn w-100 py-2 fw-semibold transition-all {{ request()->query('category', 'all') == 'all' ? 'btn-light shadow' : 'btn-outline-light' }}"
                                type="submit" name="category" value="all">
                                <i class="fa-solid fa-book-open me-1"></i>
                                Tất cả
                            </button>
                        </div>

                        @foreach ($categories as $category)
                            <div class="col-6 col-md-4 col-lg-2">
                                <button
                                    class="btn w-100 py-2 fw-semibold transition-all {{ request()->query('category', 'all') == $category['category'] ? 'btn-light shadow' : 'btn-outline-light' }}"
                                    type="submit" name="category" value="{{ $category['category'] }}">
                                    {{ $category['category'] }}
                                </button>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>

        <!-- Danh sách sách -->
        @if ($totalBooks === 0)
            <div class="text-center py-5">
                <i class="fa-solid fa-book-open-reader text-muted" style="font-size: 80px;"></i>
                <h3 class="text-muted mt-4">Không tìm thấy sách phù hợp</h3>
                <p class="text-muted">Vui lòng thử tìm kiếm với từ khóa khác</p>
            </div>
        @else
            <!-- Thông tin kết quả -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">
                    <span class="text-muted">Tìm thấy</span>
                    <span class="text-primary fw-bold">{{ $totalBooks }}</span>
                    <span class="text-muted">sản phẩm</span>
                </h5>
            </div>

            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4" style="background-color: #fbe3e8;">
                @foreach ($books as $book)
                    @include('components.book-card', ['book' => $book])
                @endforeach
            </div>

            <!-- Phân trang -->
            <div class="d-flex justify-content-center mt-5">
                {{ $books->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        @endif

        @if ($recommendedBooks && count($recommendedBooks))
            <h4 class="fw-bold mt-5">Bạn có thể thích</h4>
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4" style="background-color: #fbe3e8;">
                @foreach ($recommendedBooks as $book)
                    @include('components.book-card', ['book' => $book])
                @endforeach
            </div>
        @endif

        <div>
            <a href="{{route('gemini.index')}}">TEST</a>
        </div>
    </div>
    <script>
        setTimeout(function() {
            const alert = document.getElementById('success-alert');
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    </script>
@endsection
