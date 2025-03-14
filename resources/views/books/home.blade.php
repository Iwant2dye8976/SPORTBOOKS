@extends('layouts.app')

@section('title', 'Trang Chủ')

@section('banner')
    <img class="img-fluid" src="{{ asset('imgs/tc-banner-t5.png') }}" alt="Banner">
@endsection

@section('content')
    {{-- <div class="container">
    
    </div> --}}
        @if($totalBooks === 0)
            <div class="text text-center text-muted">
                KHÔNG TÌM THẤY SÁCH
            </div>
        @else
        <div class="row row-sm-1 row-cols-md-5 g-4">
        @foreach ($books as $book)
        <div class="col">
          <div class="card h-100">
            <img src="https://i.imgflip.com/2/6pwb6a.jpg" class="card-img-top" alt="Image">
            <div class="card-body">
              <p class="card-text fw-bold fs-5 text-center"> <a class="text-decoration-none text-dark" href="{{ route('books.detail', $book->id) }}"> {{ $book->title }} </a> </p>
            </div>
            <div class="card-footer">
                <p class="text text-danger fw-bolder text-center"> ${{ $book->price }} </p>
            </div>
          </div>
        </div>
        @endforeach
        </div>
        @endif
@endsection
