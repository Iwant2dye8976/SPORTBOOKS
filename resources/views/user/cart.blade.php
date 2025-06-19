@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
    <div class="my-5">
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
        @if ($cart_count === 0)
            <div class="alert alert-warning text-center row">
                <p class="p-0 m-0">Giỏ hàng trống!</p>
            </div>
        @else
            <div class="row row-cols-auto" style="min-height:max-content;">
                <div class="col-12 border border-dark rounded"
                    style="background-color: #fffaf0; max-height: 900px; overflow-y: auto;">
                    <div class="row row-cols-2 mb-4 pb-4 pt-1 px-1 sticky-top"
                        style="background-color: #fffaf0; z-index: 999;">
                        <div class="col">
                            <h2 class="text-start sticky-top">Giỏ hàng</h2>
                        </div>
                        <div class="col mb-4">
                            <h4 class="text-end text-secondary">{{ $cart_count }} sản phẩm</h4>
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
                    @foreach ($cartItems as $item)
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
                                <input class="form-control w-50 border border-dark book-quantity" name="book_quantity"
                                    type="number" min="1" max="50" value="{{ $item->book_quantity }}"
                                    id="quantity-{{ $item->book->id }}" onblur="updateCart({{ $item->book->id }});"
                                    required>
                            </div>
                            <div class="col d-flex justify-content-center align-items-center fw-bold">
                                {{ number_format(ceil($item->book->price * 25000), 0, ',', '.') }}đ
                            </div>
                            <input class="book-price" step="0.01" type="number" value="{{ $item->book->price, 2 }}"
                                id="{{ $item->book->id }}price" hidden>
                            <div class="col d-flex justify-content-center align-items-center fw-bold">
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a class="text-decoration-none fs-4" href="{{ route('cart.remove', $item->id) }}"
                                        onclick="event.preventDefault();
                            this.closest('form').submit();"><span
                                            class="text text-secondary">X</span></a>
                                </form>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
                {{-- <div class="col-4 border border-dark border-start-0 rounded-end pt-1 px-4" style="background-color: #c4c3d0">
                    <div class="row row-cols-2 mb-4">
                        <div class="col pt-4">
                            <h2 class="text-start">Tổng kết</h2>
                        </div>
                    </div>
                    <hr>
                    <div class="row rows-col">
                        <div class="col-12">
                            <h4 class="fw-bold">Hình thức vận chuyển</h4>
                            <select name="shipping" id="shipping" class="form-select" onchange="updateTotalPrice()">
                                <option value="economy" data-fee="0.6">Tiết kiệm (+$0.60)</option>
                                <option value="standard" data-fee="1.2">Tiêu chuẩn (+$1.20)</option>
                                <option value="fast" data-fee="2">Nhanh (+$2.00)</option>
                                <option value="express" data-fee="4">Hỏa tốc (+$4.00)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <hr>
                            <h4 class="fw-bold">Chi tiết</h4>
                            <div>
                                <div class="d-flex justify-content-between">
                                    <p>Tiền sách:</p>
                                    <p><span id="book-price"
                                            class="text-dark"><span>+</span>${{ number_format($total_price, 2) }}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p>Phí vận chuyển:</p>
                                    <p><span>+</span><span id="shipping-fee" class="text-dark">$</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex-row align-items-end mb-4">
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h4 class="fw-bold">Tổng chi phí:</h4>
                            <h4> <span id="total-price" class="text-dark">${{ number_format($total_price, 2) }}</h4>
                        </div>
                    </div>
                </div> --}}
            </div>
        @endif

        @if ($cart_count != 0)
            <div class="d-fex justify-content-center mt-3 row border border-dark border-1 rounded px-3 py-3">
                <h2>Thông tin đặt hàng</h2>
                <hr>
                <form class="w-50" method="POST" action="{{ route('checkout') }}" onsubmit="disableButton()">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="recipient_name">Họ và tên</label>
                        <input class="form-control" type="text" name="recipient_name" id="recipient_name"
                            value="{{ $user->name }}">
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
                            <option value="0.6" data-fee="0.6">Tiết kiệm (+15.000đ)</option>
                            <option value="1.2" data-fee="1.2">Tiêu chuẩn (+30.000đ)</option>
                            <option value="2" data-fee="2">Nhanh (+50.000đ)</option>
                            <option value="4" data-fee="4">Hỏa tốc (+100.000đ)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <hr>
                        <h4 class="fw-bold">Chi tiết thanh toán</h4>
                        <div>
                            <div class="d-flex justify-content-between">
                                <p>Tiền sách:</p>
                                <p id="book-price-detail"><span
                                        class="text-dark"><span>+</span>{{ number_format(ceil($total_price * 25000), 0, ',', '.') }}đ
                                </p>
                                <input name="books-price" id="book-price-detail-i" type="number" step="0.01"
                                    value="{{ number_format($total_price, 2) }}" hidden>
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
                                    class="p-0 form-control w-50 text-end fs-4 fw-bold border-0 total-price"
                                    type="number" step="0.01" value="{{ $total_price }}" readonly hidden>
                            </div>
                            {{-- <h4> <span id="total-price" class="text-dark">${{ number_format($total_price, 2) }}</h4> --}}
                        </div>
                    </div>
                    <button id="submit-button" class="btn btn-dark form-control" type="submit">
                        Đặt hàng
                    </button>
                </form>
            </div>
        @endif
    </div>
    <script>
        function updateTotalPrice() {
            let shippingSelect = document.getElementById("shipping");
            let selectedOption = shippingSelect.options[shippingSelect.selectedIndex];
            let fee = parseFloat(selectedOption.getAttribute("data-fee"));

            document.getElementById('shipping-fee').textContent = Math.ceil(fee * 25000).toLocaleString('vi-VN') + "đ";

            let totalBookPrice = 0;

            document.querySelectorAll('.book').forEach(element => {
                let quantity = parseInt(element.querySelector('.book-quantity').value);
                let price = parseFloat(element.querySelector('.book-price').value);
                totalBookPrice += quantity * price;
            });

            document.getElementById('book-price-detail').textContent = "+" + Math.ceil(totalBookPrice * 25000)
                .toLocaleString('vi-VN') + "đ";

            document.getElementById('book-price-detail-i').value = totalBookPrice.toFixed(2);

            let totalPrice = (totalBookPrice + fee).toFixed(2);
            console.log(totalPrice);

            document.querySelectorAll('.total-price').forEach(element => {
                if (element.tagName === "INPUT") {
                    element.value = totalPrice;
                } else {
                    element.textContent = Math.ceil(totalPrice * 25000).toLocaleString('vi-VN') + "đ";
                }
            });
        }


        function updateCart(bookId) {
            let quantityInput = document.getElementById("quantity-" + bookId);
            let quantity = parseInt(quantityInput.value);

            if (!quantity || quantity < 1 || quantity > 50) {
                quantityInput.value = 1;
            }

            updateTotalPrice();

            fetch(`/cart/update`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    body: JSON.stringify({
                        book_id: bookId,
                        quantity: quantity
                    })
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log("Cập nhật giỏ hàng thành công");
                    }
                }).catch(error => console.error("Lỗi cập nhật giỏ hàng:", error));

        }

        window.onload = function() {
            updateTotalPrice();
        };

        function disableButton() {
            let button = document.getElementById('submit-button');
            button.disabled = true;
            button.innerText = 'Đang xử lý...';
        }
    </script>

@endsection
