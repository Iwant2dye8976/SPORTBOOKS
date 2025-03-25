@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
    <div class="my-4">
        <a class="text text-decoration-none text-dark fs-4" href="{{ url('/orders') }}">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    @if (session('success'))
        <div class="row alert alert-success text-center" id="success-alert">
            <p class="p-0 m-0">{{ session('success') }}</p>
        </div>
    @endif
    @if (session('error'))
        <div class="row alert alert-danger text-center" id="error-alert">
            <p class="p-0 m-0">{{ session('error') }}</p>
        </div>
    @endif

    <div class="row mt-2 border border-dark border-1 rounded px-3 pb-3 mb-2"
        style="background-color: #fffaf0; max-height: 900px; overflow-y: auto;">
        <div class="row row-cols-2 pb-4 pt-1 px-1 sticky-top" style="background-color: #fffaf0; z-index: 999;">
            <div class="col">
                <h2 class="text-start sticky-top">Chi tiết đơn hàng</h2>
            </div>
            <div class="col mb-3">
                <h4 class="text-end text-secondary">{{ $product_count }} sản phẩm</h4>
            </div>
            <div class="col-4">
                <h5 class="text text-secondary">Trạng thái đơn hàng:
                    @switch($order_information->status)
                        @case(-1)
                            <span class="text text-warning fw-bold">Chờ xử lý</span>
                        @break

                        @case(0)
                            <span class="text text-danger fw-bold">Đã hủy</span>
                        @break

                        @case(1)
                            <span class="text text-success fw-bold">Đã xác nhận</span>
                        @break

                        @default
                            <span class="text text-dark fw-bold">Trạng thái không xác định</span>
                    @endswitch
                </h5>
            </div>
            <div class="col-12 mt-3">
                <hr>
            </div>
            <div class="col-3 text-center">
                Ảnh sản phẩm
            </div>
            <div class="col-3 text-center">
                Tên sản phẩm
            </div>
            <div class="col-3 text-center">
                Số lượng
            </div>
            <div class="col-3 text-center">
                Giá sản phẩm
            </div>
            <div class="col-12">
                <hr>
            </div>
        </div>
        <div class="px-3">
            @foreach ($order_details as $item)
                <div class="row book">
                    <div class="col">
                        <a href="{{ route('admin.detail', $item->book->id) }}">
                            <img class="img-fluid" src="{{ $item->book->image_url }}" alt="Ảnh sách" width="200">
                        </a>
                    </div>
                    <div class="col d-flex justify-content-start align-items-center fw-bold">
                        <h5 class="text-center">{{ $item->book->title }}</h5>
                    </div>
                    <div class="col d-flex justify-content-center align-items-center fw-bold">
                        <h5 class="text-center">{{ $item->book_quantity }}</h5>
                    </div>
                    <div class="col d-flex justify-content-center align-items-center fw-bold book-price"
                        id="{{ $item->book->id }}price">
                        ${{ number_format($item->book->price, 2) }}
                    </div>
                </div>
                <hr>
            @endforeach
        </div>
    </div>
    <div class="d-fex justify-content-center mt-3 row border border-dark border-1 rounded px-3 py-3 mb-5">
        <h2>Thông tin đặt hàng</h2>
        <hr>
        <div class="w-50">
            <div class="mb-3">
                <label class="form-label" for="recipient_name">Họ và tên</label>
                <input class="form-control" type="text" value="{{ $order_information->recipient_name }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label" for="shipping_address">Địa chỉ nhận hàng</label>
                <input class="form-control" type="text" name="shipping_address" id="shipping_address"
                    value="{{ $order_information->shipping_address }}">
                @error('address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="phone_number">Số điện thoại</label>
                <input class="form-control" type="tel" name="phone_number" id="phone_number"
                    value="{{ $order_information->phone_number }}">
                @error('phone-number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="note">Ghi chú</label>
                <textarea class="form-control" name="note" id="note" cols="10" rows="7">{{ $order_information->note }}</textarea>
                @error('note')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="shipping">Phương thức vận chuyển</label>
                <select name="shipping" id="shipping" class="form-select" disabled>
                    <option value="0.6" {{ $order_information->shipping_fee == 0.6 ? 'selected' : '' }}>Tiết kiệm
                        (+$0.60)</option>
                    <option value="1.2" {{ $order_information->shipping_fee == 1.2 ? 'selected' : '' }}>Tiêu chuẩn
                        (+$1.20)</option>
                    <option value="2" {{ $order_information->shipping_fee == 2 ? 'selected' : '' }}>Nhanh (+$2.00)
                    </option>
                    <option value="4" {{ $order_information->shipping_fee == 4 ? 'selected' : '' }}>Hỏa tốc
                        (+$4.00)
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <hr>
                <h4 class="fw-bold">Chi tiết thanh toán</h4>
                <div>
                    <div class="d-flex justify-content-between">
                        <p>Tiền sách:</p>
                        <p id="book-price-detail"><span
                                class="text-dark"><span>+</span>${{ number_format($order_information->books_price, 2) }}
                        </p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Phí vận chuyển:</p>
                        <p><span>+</span><span id="shipping-fee" class="text-dark">${{ $order_information->shipping_fee }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="d-flex-row align-items-end mb-3">
                <hr>
                <div class="d-flex justify-content-between">
                    <h4 class="fw-bold">Tổng chi phí:</h4>
                    <div class="d-flex justify-content-end">
                        <h4 class="total-price"></h4>
                        <h4>${{ $order_information->total }}</h4>
                    </div>
                </div>
            </div>
            @if ($order_information->status == -1)
                <form class="text-center" action="{{ route('orders.cancel', $order_information->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="number" value="{{ $order_information->id }}" name="order_id" hidden>
                    <button type="submit" class="form-control btn btn-danger">HỦY ĐƠN HÀNG</button>
                </form>
            @endif
        </div>
    </div>
@endsection
