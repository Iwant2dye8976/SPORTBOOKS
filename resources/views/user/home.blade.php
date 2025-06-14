@extends('layouts.app')

@section('title', 'Trang Chủ')

@section('banner')
    <img class="img-fluid" src="{{ asset('imgs/banner-2.png') }}" alt="Banner" style="height: 320px;">
@endsection

@section('content')
    @if (request()->query('verified') == 1)
        <div id="success-alert" class="alert alert-success text-center">
            Email của bạn đã được xác minh thành công!
        </div>
    @endif
    <div class="border border-2 my-4" style="background-color: #E4C087;">
        <div class="ms-3 py-2 d-flex align-items-center">
            <div class="row row-cols-auto">
                <div class="col d-flex align-items-center">
                    <h4 class="text-decoration-underline"><i class="fa-solid fa-filter"></i>Bộ lọc</h4>
                </div>
                <form action="{{ route('filter') }}" method="GET" class="col-12 row row-cols-auto">
                    <input type="hidden" name="keyword" value="{{ rawurldecode(request('keyword')) }}">
                    <div class="col-12 col-md text-center">
                        <button class="text-uppercase btn w-100" type="submit" name="category" value="all"
                            style="{{ request()->query('category', 'all') == 'all' ? 'background-color: #BC7C7C; color: white;' : '' }}">
                            Tất cả
                        </button>
                    </div>
                    @foreach ($categories as $category)
                        <div class="col-12 col-md text-center">
                            <button class="text-uppercase btn w-100" type="submit" name="category"
                                value="{{ $category['category'] }}"
                                style="{{ request()->query('category', 'all') == $category['category'] ? 'background-color: #BC7C7C; color: white;' : '' }}">
                                {{ $category['category'] }}
                            </button>
                        </div>
                    @endforeach
                </form>
            </div>
        </div>
    </div>

    @if ($totalBooks === 0)
        <div class="text text-center text-muted">
            KHÔNG TÌM THẤY SÁCH
        </div>
    @else
        <div class="row row-cols-1 row-cols-sm-3 row-cols-md-5 g-4">
            @foreach ($books as $book)
                <div class="col">
                    <div class="card h-100" style="background-color: #f2f3f4">{{-- https://static.kinhtedothi.vn/w960/images/upload/2021/12/24/sach-huan-1.jpg --}}
                        <a href="{{ route('detail', $book->id) }}">
                            <img src="{{ $book->image_url }}" class="card-img-top" alt="Image">
                        </a>
                        <div class="card-body  d-flex justify-content-center align-items-center">
                            <p class="card-text fw-bold fs-5 text-center">
                                <a class="text-decoration-none text-dark" href="{{ route('detail', $book->id) }}">
                                    {{ $book->title }}
                                </a>
                            </p>
                        </div>
                        <div class="card-footer">
                            <p class="text text-danger fw-bolder text-center">
                                {{ number_format(ceil($book->price * 25000), 0, ',', '.') }}đ
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Hiển thị phân trang -->
        <div class="d-flex justify-content-center mt-4">
            {{ $books->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    @endif
@endsection
