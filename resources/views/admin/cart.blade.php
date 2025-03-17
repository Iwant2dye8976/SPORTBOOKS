@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
    <div class="mt-5">
        @if (session('success'))
            <div class="alert alert-success text-center" id="success-alert">
                {{ session('success') }}
            </div>
        @endif
        @if ($cart_count === 0)
            <div class="alert alert-warning text-center">Giỏ hàng trống!</div>
        @else
            <div class="row row-cols-auto" style="min-height:max-content;">
                <div class="col-8 border border-start rounded-start"
                    style="background-color: #fffaf0; max-height: 500px; overflow-y: auto;">
                    <div class="row row-cols-2 mb-4 pb-4 pt-1 px-1 sticky-top" style="background-color: #fffaf0">
                        <div class="col">
                            <h2 class="text-start sticky-top">Giỏ hàng</h2>
                        </div>
                        <div class="col mb-4">
                            <h4 class="text-end text-secondary">{{ $cart_count }} sản phẩm</h4>
                        </div>
                        <div class="col-12 mt-3">
                            <hr>
                        </div>
                    </div>
                    @foreach ($cartItems as $item)
                        <div class="row">
                            <div class="col">
                                <a href="{{ route('admin.detail', $item->book->id) }}">
                                    <img class="img-fluid"
                                        src="https://static.kinhtedothi.vn/w960/images/upload/2021/12/24/sach-huan-1.jpg"
                                        alt="Ảnh sách" width="200">
                                </a>
                            </div>
                            <div class="col d-flex justify-content-start align-items-center fw-bold">
                                <h5 class="text-center">{{ $item->book->title }}</h5>
                            </div>
                            <div class="col d-flex justify-content-center align-items-center fw-bold">
                                <input class="form-control w-50 border border-dark" name="book_quantity" type="number"
                                    min="1" max="999", value="{{ $item->book_quantity }}">
                            </div>
                            <div class="col d-flex justify-content-center align-items-center fw-bold">
                                ${{ number_format($item->book->price, 2) }}
                            </div>
                            <div class="col d-flex justify-content-center align-items-center fw-bold">
                                <form action="{{ route('admin.cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a class="text-decoration-none fs-4" href="{{ route('admin.cart.remove', $item->id) }}"
                                        onclick="event.preventDefault();
                            this.closest('form').submit();"><span
                                            class="text text-secondary">X</span></a>
                                </form>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
                <div class="col-4 border border-end rounded-end pt-1 px-4" style="background-color: #c4c3d0">
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
                        <div class="d-grid mt-2">
                            <button class="btn text-light" style="background-color: #36454f">Thanh
                                toán</button>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function updateTotalPrice() {
                    let shippingSelect = document.getElementById("shipping");
                    let selectedOption = shippingSelect.options[shippingSelect.selectedIndex];
                    let fee = parseFloat(selectedOption.getAttribute("data-fee"));
                    document.getElementById('shipping-fee').textContent = "$" + fee;
                    let totalPriceElement = document.getElementById("total-price");
                    let totalPrice = parseFloat("{{ number_format($total_price, 2, '.', '') }}");

                    totalPriceElement.textContent = "$" + (totalPrice + fee).toFixed(2);

                }
                window.onload = function() {
                    updateTotalPrice();
                };
                setTimeout(function() {
                    let alert = document.getElementById('success-alert');
                    if (alert) {
                        alert.style.transition = "opacity 0.5s ease";
                        alert.style.opacity = "0";
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 3000); // Ẩn sau 3 giây (3000ms)
            </script>
        @endif
    </div>
@endsection
