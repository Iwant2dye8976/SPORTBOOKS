@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng')
@section('content')
    @if (!Auth::user()->hasVerifiedEmail())
        <div class="container text-center mt-5">
            <h4>Tài khoản của bạn chưa được xác minh</h4>
            <p>Để tiếp tục hành động, vui lòng <span><a href="{{ route('verification.notice') }}"
                        class="text text-decoration-underline">xác minh tài khoản của bạn.</a></span></p>
        </div>
    @else
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

        <div class="my-4">
            <a class="text text-decoration-none text-dark fs-4" href="{{ url('/orders') }}">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>

        @include('components.process-bar')

        <div class="row mt-5 border border-dark border-1 rounded px-3 pb-3 mb-2"
            style="background-color: #fffaf0; max-height: 900px; overflow-y: auto;">
            <div class="row row-cols-2 pb-4 pt-1 px-1 sticky-top" style="background-color: #fffaf0; z-index: 999;">
                <div class="col">
                    <h2 class="text-start sticky-top">Chi tiết đơn hàng</h2>
                </div>
                <div class="col mb-3">
                    <h4 class="text-end text-secondary">{{ $product_count }} sản phẩm</h4>
                </div>
                <div class="col-5">
                    <h5 class="text text-secondary">Trạng thái đơn hàng:
                        @switch($order_information->status)
                            @case(-1)
                                <span class="text text-warning fw-bold">Chờ xử lý</span>
                            @break

                            @case(0)
                                <span class="text text-danger fw-bold">Đã hủy</span>
                            @break

                            @case(1)
                                <span class="text text-warning fw-bold">Chờ thanh toán</span>
                            @break

                            @case(2)
                                <span class="text text-warning fw-bold">Chờ giao hàng</span>
                            @break

                            @case(3)
                                <span class="text text-warning fw-bold">Đang giao hàng</span>
                            @break

                            @case(4)
                                <span class="text text-success fw-bold">Đã nhận hàng</span>
                            @break

                            @default
                                <span class="text text-primary fw-bold">Trạng thái không xác định</span>
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
                            <a href="{{ route('detail', $item->book->id) }}">
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
                            {{ number_format(ceil($item->book->price * 25000), 0, ',', '.') . 'đ' }}
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
                        value="{{ $order_information->shipping_address }}" readonly>
                    @error('address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="phone_number">Số điện thoại</label>
                    <input class="form-control" type="tel" name="phone_number" id="phone_number"
                        value="{{ $order_information->phone_number }}" readonly>
                    @error('phone-number')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="note">Ghi chú</label>
                    <textarea class="form-control" name="note" id="note" cols="10" rows="7" readonly>{{ $order_information->note }}</textarea>
                    @error('note')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="shipping">Phương thức vận chuyển</label>
                    <select name="shipping" id="shipping" class="form-select" disabled>
                        <option value="0.6" {{ $order_information->shipping_fee == 0.6 ? 'selected' : '' }}>Tiết kiệm
                            (+15.000đ)</option>
                        <option value="1.2" {{ $order_information->shipping_fee == 1.2 ? 'selected' : '' }}>Tiêu chuẩn
                            (+30.000đ)</option>
                        <option value="2" {{ $order_information->shipping_fee == 2 ? 'selected' : '' }}>Nhanh
                            (+50.000đ)
                        </option>
                        <option value="4" {{ $order_information->shipping_fee == 4 ? 'selected' : '' }}>Hỏa tốc
                            (+100.000đ)
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
                                    class="text-dark"><span>+</span>{{ number_format(ceil($order_information->books_price * 25000), 0, ',', '.') }}đ
                            </p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p>Phí vận chuyển:</p>
                            <p><span>+</span><span id="shipping-fee"
                                    class="text-dark">{{ number_format(ceil($order_information->shipping_fee * 25000), 0, ',', '.') }}đ
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
                            <h4>{{ number_format(ceil($order_information->total * 25000), 0, ',', '.') }}đ</h4>
                        </div>
                    </div>
                </div>
                @if ($order_information->status == -1)
                @endif
                @switch($order_information->status)
                    @case(-1)
                        <form class="text-center" action="{{ route('orders.cancel', $order_information->id) }}" method="POST"
                            onsubmit="disableButton();">
                            @csrf
                            <input type="number" value="{{ $order_information->id }}" name="order_id" hidden>
                            <a class="form-control btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal">HỦY ĐƠN
                                HÀNG</a>
                            <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="deleteModal"
                                aria-hidden="true" data-bs-backdrop="static">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">HỦY ĐƠN HÀNG</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-break">
                                            Bạn có chắc muốn <strong class="text text-danger">hủy đơn hàng này?</strong>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger">XÁC NHẬN</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">HỦY</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @break

                    @case(1)
                        <hr>
                        <form action="{{ route('checkout.vnpay', $order_information->id) }}" method="POST">
                            @csrf
                            <input name="total_price" type="number" value="{{ ceil($order_information->total * 25000) }}"
                                hidden>
                            <input type="number" name="order_id" value="{{ $order_information->id }}" hidden>
                            <label class="form-label fs-4 fw-bold" for="payment_method">Phương thức thanh toán</label>
                            <select name="payment_method" id="payment_method" class="form-select mb-3">
                                <option value="cod">Thanh toán khi nhận hàng</option>
                                <option value="vnpay">VN Pay</option>
                            </select>
                            <button class="form-control btn btn-primary" name="redirect">THANH TOÁN</button>
                        </form>
                    @break
                @endswitch
            </div>
        </div>
    @endif
@endsection
