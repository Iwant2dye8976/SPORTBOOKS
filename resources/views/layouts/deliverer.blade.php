<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SPORTBOOKS')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .navbar {
            position: relative;
            z-index: 1000;
        }

        .menu .l {
            font-size: 20px;
            text-decoration: none;
            display: block;
            position: relative;
            padding: 4px 0;
            margin: 10px;
        }

        .menu .l::before {
            content: "";
            width: 100%;
            height: 4px;
            position: absolute;
            left: 0;
            bottom: 0;
            background: #fff;
            transition: 0.5s transform ease;
            transform: scale3d(0, 1, 1);
            transform-origin: 0 50%;
        }

        .menu .l:hover::before {
            transform: scale3d(1, 1, 1);
        }

        .menu .l::before {
            background: #524bcb;
            transform-origin: 100% 50%;
        }

        .menu .l:hover::before {
            transform-origin: 0 50%;
        }

        .search-box {
            position: relative;
            display: inline-block;
        }

        .search-box button {
            position: absolute;
            left: 5px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            padding: 0px;
            color: gray;
        }

        .search-box input {
            padding-left: 30px;
            height: 40px;
            width: 500px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>

    @stack('styles') <!-- Cho phép trang con thêm CSS riêng -->
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
        <div class="container-fluid ps-4">
            <!-- Logo -->
            <a class="navbar-brand fw-bold text-primary fs-2"
                href="{{ Auth::check() ? (Auth::user()->type === 'user' ? url('') : route('delivery.orders-m')) : url('home') }}">SPORTBOOKS
                DELIVERY</a>

            <!-- Toggle button cho mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav menu">
                    <li class="nav-item">
                        <a class="nav-link l" href="{{ route('delivery.orders-m') }}">Quản lý đơn hàng</a>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <a class="nav-link l dropdown-toggle" role="button" data-bs-toggle="dropdown">
                                Phân loại
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="">Đơn chờ giao</a></li>
                                <li><a class="dropdown-item" href="">Đơn đã giao</a></li>
                                <li><a class="dropdown-item" href="">Đơn bị hủy</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link l" href=" {{route('delivery.my-orders')}} ">Đơn đã nhận
                            @if ($my_orders > 0)
                                <span
                                    class="position-absolute top-10 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $my_orders > 99 ? '99+' : $my_orders }}
                                </span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>

            <div class="d-flex justify-content-end collapse navbar-collapse menu" id="navbarNav">
                @auth
                    <div class="dropdown pe-4">
                        <button class="btn btn-outline-secondary position-relative dropdown-toggle" type="button"
                            id="account" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('delivery.profile.edit') }}">Tài khoản</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                    this.closest('form').submit();">Đăng
                                        xuất</a>
                                </form>
                            </li>
                        </ul>

                    </div>
                @endauth

                @guest
                    @if (!Route::is('login'))
                        <a class="nav-link l" href="{{ route('login') }}">Đăng nhập</a>
                    @endif
                    <span class="mx-2">|</span>
                    @if (!Route::is('register'))
                        <a class="nav-link l" href="{{ route('register') }}">Đăng kí</a>
                    @endif
                @endguest
            </div>
        </div>
    </nav>

    <div class="container-md-fluid container-xxl mt-4">
        @yield('banner')
    </div>

    <!-- Nội dung của từng trang -->
    <div class="container-md-fluid container-xxl mt-4 px-4 min-vh-100">
        @yield('content')
    </div>

    <div>
        @include('components.footer')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
    <script src="{{ asset('js/alert.js') }}"></script>
    <script src="{{ asset('js/disablebutton.js') }}"></script>
    <script src="{{ asset('js/showAlert.js') }}"></script>

</body>

</html>
