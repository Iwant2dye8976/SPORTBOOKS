@extends('layouts.app')

@section('title', 'Trang Chủ')

@section('banner')
    <img class="img-fluid" src="{{ asset('imgs/tc-banner-t5.png') }}" alt="Banner">
@endsection

@section('content')
    <div class="border border-2 my-4">
        <div class="ms-3 py-2 d-flex align-items-center">
            <div class="row row-cols-auto">
                <div class="col d-flex align-items-center">
                    <h4 class="text-decoration-underline"><i class="fa-solid fa-filter"></i>Bộ lọc</h4>
                </div>
                <form action="{{ route('filter') }}" method="GET" class="row row-cols-auto">
                    <div class="col">
                        <button class="text-uppercase btn" type="submit" name="category" value="all"
                            style="{{ request()->query('category', 'all') == 'all' ? 'background-color: #0892d0; color: white;' : '' }}">
                            All
                        </button>
                    </div>
                    @foreach ($categories as $category)
                        <div class="col">
                            <button class="text-uppercase btn" type="submit" name="category"
                                value="{{ $category['category'] }}"
                                style="{{ request()->query('category', 'all') == $category['category'] ? 'background-color: #0892d0; color: white;' : '' }}">
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
        <div class="row row-sm-1 row-cols-md-5 g-4">
            @foreach ($books as $book)
                <div class="col">
                    <div class="card h-100" style="background-color: #f2f3f4">
                        <img src="https://static.kinhtedothi.vn/w960/images/upload/2021/12/24/sach-huan-1.jpg"
                            class="card-img-top" alt="Image">
                        <div class="card-body">
                            <p class="card-text fw-bold fs-5 text-center">
                                <a class="text-decoration-none text-dark" href="{{ route('user.detail', $book->id) }}">
                                    {{ $book->title }}
                                </a>
                            </p>
                        </div>
                        <div class="card-footer">
                            <p class="text text-danger fw-bolder text-center">
                                ${{ $book->price }}
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
