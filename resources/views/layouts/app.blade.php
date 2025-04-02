<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SPORTBOOKS')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            transform-origin: 100% 50%;
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
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
        <div class="container-fluid ps-4">
            <!-- Logo -->
            <a class="navbar-brand fw-bold text-primary fs-2" href="{{ url('home') }}">SPORTBOOKS</a>

            <!-- Toggle button cho mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav menu">
                    <li class="nav-item">
                        <a class="nav-link l" aria-current="page" href="{{ url('/home') }}">Trang
                            chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link l" href="{{ route('cart') }}">Giỏ
                            hàng
                            @if ($cart_count > 0)
                                <span
                                    class="position-absolute top-10 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $cart_count > 99 ? '99+' : $cart_count }}
                                </span>
                            @endif
                        </a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link l" href="{{ route('orders') }}">Đơn
                            hàng
                            @if ($order_count > 0)
                                <span
                                    class="position-absolute top-10 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $order_count > 99 ? '99+' : $order_count }}
                                </span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link l" href="{{ route('contact') }}">Liên hệ</a>
                    </li>
                </ul>
            </div>

            <div class="d-flex justify-content-end collapse navbar-collapse menu" id="navbarNav">
                <!-- Thanh tìm kiếm -->
                <form class="me-2" action=" {{ route('search') }} " method="GET">
                    <div class="search-box">
                        <button type="submit" class="nav-link">
                            <i class="fa fa-search"></i>
                        </button>
                        <input class="form-control" type="search" name="keyword" placeholder="Tìm kiếm..."
                            value="{{ rawurldecode(request('keyword')) }}">
                    </div>
                </form>

                @auth
                    <div class="dropdown pe-4">
                        <button class="btn btn-outline-secondary position-relative dropdown-toggle" type="button"
                            id="account" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Tài
                                    khoản</a></li>
                            @if (Auth::check() && Auth::user()->type === 'admin')
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.index') }}">Quản lý</a>
                                </li>
                            @endif
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
    <div class="container-md-fluid container-xxl mt-4 min-vh-100" style="z-index: 999;">
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

</body>

</html>
