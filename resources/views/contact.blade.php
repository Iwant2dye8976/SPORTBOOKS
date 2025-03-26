@extends('layouts.app')

@section('content')
    <div class="container py-5">
        @if (session('success'))
            <div class="alert alert-success text-center" id="success-alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger text-center" id="error-alert">
                {{ session('error') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded">
                    <div class="card-header bg-primary text-white text-center fw-bold">
                        Liên hệ SPORTBOOKS
                    </div>
                    <div class="card-body">
                        <h5 class="text-center fw-bold">Giới thiệu về SPORTBOOKS</h5>
                        <p class="text-muted text-center">
                            SPORTBOOKS là trang web chuyên cung cấp tất cả các loại sách từ văn học, khoa học, kỹ năng sống
                            đến thể thao. Chúng tôi cam kết mang đến cho khách hàng những đầu sách chất lượng với giá cả hợp
                            lý.
                        </p>
                        <hr>
                        <h5 class="text-center fw-bold">Thông tin liên hệ</h5>
                        <ul class="list-unstyled text-center">
                            <li>
                                <a class="text text-dark text-decoration-dot" href="https://maps.app.goo.gl/z6WjkBhVmeNFmsvQ7" target="_blank"><i class="fas fa-map-marker-alt"></i>
                                    Địa chỉ: 123, Đường Nguyễn Văn Thể Thao, Hà Đông, Hà
                                    Nội</a>
                            </li>
                            <li><i class="fas fa-phone-alt"></i> Số điện thoại: <a href="tel:+84977923301">+84 977 923
                                    301</a></li>
                            <li><i class="fas fa-envelope"></i> Email: <a
                                    href="mailto:dangquocdatyahoocomvn@gmail.com">dangquocdatyahoocomvn@gmail.com</a></li>
                        </ul>
                        <hr>
                        <h5 class="text-center fw-bold">Gửi tin nhắn</h5>
                        <form action="{{ route('contact.send') }}" method="POST" onsubmit="disableButton()">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Họ và tên</label>
                                <input name="name" id="name" type="text" class="form-control"
                                    placeholder="Nhập họ và tên" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" name="email" type="email" class="form-control"
                                    placeholder="Nhập email" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Nội dung</label>
                                <textarea id="message" name="message" class="form-control" rows="4" placeholder="Nhập nội dung" required></textarea>
                            </div>
                            <div class="text-center">
                                <button id="submit-button" type="submit" class="btn btn-primary form-control w-25">Gửi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        setTimeout(function() {
            let success_alert = document.getElementById('success-alert');
            let error_alert = document.getElementById('error-alert');
            if (success_alert) {
                success_alert.style.transition = "opacity 0.5s ease";
                success_alert.style.opacity = "0";
                setTimeout(() => success_alert.remove(), 500);
            }
            if (error_alert) {
                error_alert.style.transition = "opacity 0.5s ease";
                error_alert.style.opacity = "0";
                setTimeout(() => error_alert.remove(), 500);
            }
        }, 3000);
    </script>
@endsection
