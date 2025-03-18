@extends('layouts.app')

@section('title', 'Mua ngay')

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
        <div class="col-5 text-center book-img">
            <img src="https://i.imgflip.com/2/6pwb6a.jpg" alt="">
        </div>
        <div class="col-7 position-relative">
            <div>
                <h4 class="fw-bolder"> {{ $book->title }} </h4>
                <p class="fs-6 fw-medium">Giá bán: <span class="text text-danger"> ${{ $book->price }} </span></p>
                <p class="fs-6 fw-medium">Số lượng mua: <span class="text text-primary"> {{ $amount }} </span></p>
                <p class="fs-6 fw-medium">Tổng: <span class="text text-danger"> ${{ $book->price * $amount }} </span></p>
            </div>
        </div>
    </div>
@endsection
