@extends('layouts.app')

@section('title', 'Chi tiết sách')

{{-- @section('banner')
    <img class="img-fluid" src="{{ asset('imgs/tc-banner-t5.png') }}" alt="Banner">
@endsection --}}



@section('content')
    <style>
        .book-img img {
            max-width: 100%;
            height: 300px;
            object-fit: fill;
            object-position: center;
            border-radius: 10px;
        }
    </style>
    @if (session('error'))
        <div class="container-fluid alert alert-danger text-center" id="error-alert">
            <p class="p-0 m-0">{{ session('error') }}</p>
        </div>
    @endif
    @if (session('success'))
        <div class="container-fluid row alert alert-success text-center" id="success-alert">
            <p class="p-0 m-0">{{ session('success') }}</p>
        </div>
    @endif
    <div class="container-fluid row border border-dark border-1 rounded py-2">
        <div class="d-flex justify-content-center align-items-center col-12 col-md-5 text-center book-img">
            <img src="{{ $book->image_url }}" alt="">
        </div>
        <div class="col-7 position-relative">
            <div>
                <h4 class="fw-bolder"> {{ $book->title }} </h4>
                <p class="fs-6 fw-medium">Giá bán: <span class="text text-danger"> ${{ $book->price }} </span></p>
                <p class="fs-6 fw-medium">Tác giả: <span class="text text-dark text-decoration-underline"> {{ $book->author }} </span></p>
                <p class="fs-6 fw-medium mb-1">Mô tả:</p>
                <p class="fs-6" style="max-height: 300px; overflow-y: auto;"> {{ $book->description }} </p>
            </div>
            <div>
                <form class="row justify-content-start" method="POST" action="{{ route('cart.add', $book->id) }}"
                    onsubmit="disableButton()">
                    @csrf
                    <label class="form-label fw-medium" for="amount">Số lượng</label>

                    <div class="col-12 col-md-3 mb-1">
                        <input id="amount" type="number" name="amount" class="form-control" value="1"
                            min="1" max="999" required>
                    </div>

                    <div class="col-auto col-md-2 text-lg-center col-lg-3">
                        <a class="btn btn-success text-decoration-none" href="{{ route('buynow-v', $book->id) }}">Mua
                            ngay</a>
                    </div>

                    <div class="col-auto col-md-4">
                        <button id="submit-button" type="submit" class="btn btn-success">Thêm vào giỏ
                            hàng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container-fluid row border border-dark border-1 rounded py-2 mt-4 mb-5">
        <div class="mb-3">
            <h4 class="fw-bold">SÁCH LIÊN QUAN</h4>
            <div class="row row-cols-1 row-cols-md-5">
                @foreach ($relatedBooks as $rBook)
                    <div class="col my-2">
                        <div class="card h-100">
                            <a href="{{ route('detail', $rBook->id) }}">
                                <img src="{{ $rBook->image_url }}" class="card-img-top" alt="Image">
                            </a>
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <p class="card-text fw-bold fs-5 text-center"> <a class="text-decoration-none text-dark"
                                        href="{{ route('detail', $rBook->id) }}"> {{ $rBook->title }} </a> </p>
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
    {{-- <script>
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
        }, 3000);
    </script> --}}
@endsection
