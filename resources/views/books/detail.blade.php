@extends('layouts.app')

@section('title', 'Chi tiết sách')

{{-- @section('banner')
    <img class="img-fluid" src="{{ asset('imgs/tc-banner-t5.png') }}" alt="Banner">
@endsection --}}



@section('content')
<style>
    .book-img img {
        max-width: 100%;  /* Ảnh luôn chiếm toàn bộ chiều rộng của khung */
        height: 300px; /* Đặt chiều cao cố định cho khung */
        object-fit: fill; /* Cắt ảnh để vừa với khung mà không bị méo */
        object-position: center; /* Căn giữa ảnh */
        border-radius: 10px; /* Bo góc ảnh nếu cần */
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
                <p class="fs-6 fw-medium mb-1">Mô tả:</p>
                <p class="fs-6"> {{ $book->description }} </p>
            </div>
            <div class="position-absolute bottom-0 start-1">
                <form class="row justify-content-start" method="POST" action="{{ route('cart.process', $book->id) }}">
                    @csrf
                    <label class="form-label fw-medium" for="amount">Số lượng</label>
                    
                    <div class="col-3">
                        <input name="amount" class="form-control" type="number" value="1" min="1" required>
                    </div>
                
                    <div class="col-auto">
                        <button type="submit" name="action" value="buy_now" class="btn btn-success">Mua ngay</button>
                    </div>
                
                    <div class="col-auto">
                        <button type="submit" name="action" value="add_to_cart" class="btn btn-success">Thêm vào giỏ hàng</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
@endsection
