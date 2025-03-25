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

    @if (session('success'))
        <div class="row alert alert-success text-center" id="success-alert">
            <p class="m-0 p-0">{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="alert error-danger text-center" id="error-alert">
            <p class="m-0 p-0">{{ session('error') }}</p>
        </div>
    @endif

    {{-- <div>
        <a class="text text-decoration-none text-dark fs-4" href="{{ url()->previous() }}">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div> --}}

    <div class="row border border-dark border-1 rounded py-3">
        <div class="col-5 text-center book-img">
            <img src="{{ $book->image_url }}" alt="">
        </div>
        <div class="col-7 position-relative">
            <h4 class="fw-bolder"> {{ $book->title }} </h4>
            <p class="fs-5 fw-medium">Giá bán: <span id="price" class="text text-danger fw-bold"> ${{ $book->price }}
                </span></p>
            <div class="d-flex align-items-end">
                <label class="form-label fs-5 fw-medium m-0 pb-1" for="quantity">Số lượng</label>
                <input id="quantity" type="number" min="1" max="999" class="ms-3 form-control w-25"
                    value="1" onblur="updateQuantity();">
            </div>
            </p>
            <p class="fs-5 fw-medium" id="book-price">Tổng: <span class="text text-danger fw-bold"> ${{ $book->price }}
                </span>
            </p>
        </div>
    </div>
    <div class="d-fex justify-content-center mt-3 row border border-dark border-1 rounded px-3 py-3 mb-5">
        <h2>Thông tin đặt hàng</h2>
        <hr>
        <form class="w-50" method="POST" action="{{ route('admin.buynow', $book->id) }}">
            @csrf
            @method('post')
            <div class="mb-3">
                <label class="form-label" for="recipient_name">Họ và tên</label>
                <input class="form-control" type="text" name="recipient_name" id="recipient_name" value="{{ $user->name }}">
                @error('recipient_name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="shipping_address">Địa chỉ nhận hàng</label>
                <input class="form-control" type="text" name="shipping_address" id="shipping_address"
                    value="{{ $user->address }}">
                @error('shipping_address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="phone_number">Số điện thoại</label>
                <input class="form-control" type="tel" name="phone_number" id="phone_number"
                    value="{{ $user->phone_number }}">
                @error('phone_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="note">Ghi chú</label>
                <textarea class="form-control" name="note" id="note" cols="10" rows="7"></textarea>
                @error('note')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="shipping">Phương thức vận chuyển</label>
                <select name="shipping" id="shipping" class="form-select" onchange="updateTotalPrice()">
                    <option value="0.6" data-fee="0.6">Tiết kiệm (+$0.60)</option>
                    <option value="1.2" data-fee="1.2">Tiêu chuẩn (+$1.20)</option>
                    <option value="2" data-fee="2">Nhanh (+$2.00)</option>
                    <option value="4" data-fee="4">Hỏa tốc (+$4.00)</option>
                </select>
            </div>
            <div class="mb-3">
                <hr>
                <h4 class="fw-bold">Chi tiết thanh toán</h4>
                <div>
                    <div class="d-flex justify-content-between">
                        <p>Tiền sách:</p>
                        <p id="book-price-detail"><span
                                class="text-dark"><span>+</span>${{ number_format($book->price, 2) }}
                        </p>
                        <input name="books-price" id="book-price-detail-i" type="number" step="0.01"
                            value="{{ number_format($book->price, 2) }}" hidden>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Phí vận chuyển:</p>
                        <p><span>+</span><span id="shipping-fee" class="text-dark">$</p>
                    </div>
                </div>
            </div>
            <div class="d-flex-row align-items-end mb-3">
                <hr>
                <div class="d-flex justify-content-between">
                    <h4 class="fw-bold">Tổng chi phí:</h4>
                    <div class="d-flex justify-content-end">
                        <h4 class="total-price"></h4>
                        <input name="total-price" id="total-price"
                            class="p-0 form-control w-50 text-end fs-4 fw-bold border-0 total-price" type="number"
                            step="0.01" value="{{ $book->price }}" readonly hidden>
                    </div>
                    {{-- <h4> <span id="total-price" class="text-dark">${{ number_format($total_price, 2) }}</h4> --}}
                </div>
            </div>
            <input id="quantity-i" type="number" name="quantity" value="1" required hidden>
            <button class="btn btn-dark form-control" type="submit">
                Đặt hàng
            </button>
        </form>
    </div>
    <script>
        function updateTotalPrice() {
            let shippingSelect = document.getElementById("shipping");
            let selectedOption = shippingSelect.options[shippingSelect.selectedIndex];
            let fee = parseFloat(selectedOption.getAttribute("data-fee"));

            document.getElementById('shipping-fee').textContent = "$" + fee;

            let totalBookPrice = 0;
            let quantity = parseInt(document.getElementById('quantity').value);
            let price = parseFloat(document.getElementById('price').textContent.replace("$", ""));
            totalBookPrice += quantity * price;

            document.getElementById('book-price').textContent = "Tổng: $" + totalBookPrice.toFixed(2);
            document.getElementById('book-price-detail').textContent = "$" + totalBookPrice.toFixed(2);
            document.getElementById('book-price-detail-i').value = totalBookPrice.toFixed(2);
            document.getElementById('quantity-i').value = quantity;

            let totalPrice = (totalBookPrice + fee).toFixed(2);

            document.querySelectorAll('.total-price').forEach(element => {
                if (element.tagName === "INPUT") {
                    element.value = totalPrice;
                } else {
                    element.textContent = "$" + totalPrice;
                }
            });
        }

        window.onload = function() {
            updateTotalPrice();
        };

        function updateQuantity() {
            let quantityInput = document.getElementById("quantity");
            let quantity = parseInt(quantityInput.value);

            if (!quantity || quantity < 1 || quantity > 999) {
                quantityInput.value = 1;
            }

            updateTotalPrice();
        }
    </script>
@endsection
