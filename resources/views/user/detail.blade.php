@extends('layouts.app')

@section('title', 'Chi tiết sách')

{{-- @section('banner')
    <img class="img-fluid" src="{{ asset('imgs/tc-banner-t5.png') }}" alt="Banner">
@endsection --}}



@section('content')
    <style>
        .book-img img {
            max-width: 100%;
            /* Ảnh luôn chiếm toàn bộ chiều rộng của khung */
            height: 300px;
            /* Đặt chiều cao cố định cho khung */
            object-fit: fill;
            /* Cắt ảnh để vừa với khung mà không bị méo */
            object-position: center;
            /* Căn giữa ảnh */
            border-radius: 10px;
            /* Bo góc ảnh nếu cần */
        }
    </style>
    <div class="container-fluid row">
        @if (session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success text-center" id="success-alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="col-5 text-center book-img">
            <img src="https://static.kinhtedothi.vn/w960/images/upload/2021/12/24/sach-huan-1.jpg" alt="">
        </div>
        <div class="col-7 position-relative">
            <div>
                <h4 class="fw-bolder"> {{ $book->title }} </h4>
                <p class="fs-6 fw-medium">Giá bán: <span class="text text-danger"> ${{ $book->price }} </span></p>
                <p class="fs-6 fw-medium mb-1">Mô tả:</p>
                <p class="fs-6"> {{ $book->description }} </p>
            </div>
            <div class="position-absolute bottom-0 start-1">
                <form class="row justify-content-start" method="POST" action="{{ route('cart.process', $book->id) }}">
                    @csrf
                    <label class="form-label fw-medium" for="amount">Số lượng</label>

                    <div class="col-3">
                        <input name="amount" class="form-control" type="number" value="1" min="1"
                            max="999" required>
                    </div>

                    <div class="col-auto">
                        <button type="submit" name="action" value="buy_now" class="btn btn-success">Mua ngay</button>
                    </div>

                    <div class="col-auto">
                        <button type="submit" name="action" value="add_to_cart" class="btn btn-success">Thêm vào giỏ
                            hàng</button>
                    </div>
                </form>

            </div>
        </div>

    </div>
    <div class="container-fluid mt-4">
        <div class="mb-3">
            <h4 class="fw-bold">SÁCH LIÊN QUAN</h4>
            <div class="row row-col-md-5">
                @foreach ($relatedBooks as $rBook)
                    <div class="col">
                        <div class="card h-100">
                            <img src="https://i.imgflip.com/2/6pwb6a.jpg" class="card-img-top" alt="Image">
                            <div class="card-body">
                                <p class="card-text fw-bold fs-5 text-center"> <a class="text-decoration-none text-dark"
                                        href="{{ route('user.detail', $rBook->id) }}"> {{ $rBook->title }} </a> </p>
                            </div>
                            <div class="card-footer">
                                <p class="text text-danger fw-bolder text-center"> ${{ $rBook->price }} </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        setTimeout(function() {
            let success_alert = document.getElementById('success-alert');
            let error_alert = document.getElementById('error-alert');
            if (success_alert) {
                success_alert.style.transition = "opacity 0.5s ease";
                success_alert.style.opacity = "0";
                setTimeout(() => success_alert.remove(), 500);
            }
            if (error_alert) {
                error_alert.style.transition = "opacity 0.5s ease";
                error_alert.style.opacity = "0";
                setTimeout(() => error_alert.remove(), 500);
            }
        }, 3000); // Ẩn sau 3 giây (3000ms)
    </script>
@endsection
