@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
    <div class="container mt-5">
        @if (session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif
        <h2 class="mb-4">Giỏ hàng của bạn</h2>

        @if ($cart_count == 0)
            <div class="alert alert-warning text-center">Giỏ hàng trống!</div>
        @else
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Ảnh</th>
                        <th>Tên sách</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                        <tr>
                            <td>
                                <a href="{{ route('user.detail', $item->book->id) }}">
                                    <img src="https://static.kinhtedothi.vn/w960/images/upload/2021/12/24/sach-huan-1.jpg"
                                        alt="Ảnh sách" width="80">
                                </a>
                            </td>
                            <td class="align-middle">{{ $item->book->title }}</td>
                            <td class="align-middle">${{ number_format($item->book->price, 2) }}</td>
                            <td class="align-middle">{{ $item->book_quantity }}</td>
                            <td class="align-middle">${{ number_format($item->book->price * $item->book_quantity, 2) }}</td>
                            <td class="align-middle">
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-end">
                <h4>Tổng cộng: <span class="text-danger">${{ number_format($total_price, 2) }}</span></h4>
                <a href="" class="btn btn-success mt-3">Thanh toán</a>
            </div>
        @endif
    </div>
@endsection
