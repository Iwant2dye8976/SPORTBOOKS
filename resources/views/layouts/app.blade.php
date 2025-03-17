<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SPORTBOOKS')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .menu a {
            font-size: 20px;
            text-decoration: none;
            display: block;
            position: relative;
            padding: 4px 0;
        }

        .menu a::before {
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

        .menu a::before {
            transform-origin: 50% 50%;
            background: #8FD14F;
        }

        .menu a:hover::before {
            transform: scale3d(1, 1, 1);
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

        body {
            background-color: #F6FCFA;
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
                href="{{ Auth::check() ? (Auth::user()->type === 'user' ? url('/home') : url('/admin/home')) : url('home') }}">SPORTBOOKS</a>

            <!-- Toggle button cho mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav menu">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page"
                            href="{{ Auth::check() ? (Auth::user()->type === 'user' ? url('/home') : url('/admin/home')) : url('home') }}">Trang
                            chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ Auth::check() ? (Auth::user()->type === 'user' ? route('cart') : route('admin.cart')) : route('cart') }}">Giỏ
                            hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Liên hệ</a>
                    </li>
                </ul>
            </div>

            <div class="d-flex justify-content-end collapse navbar-collapse" id="navbarNav">
                <!-- Thanh tìm kiếm -->
                <form class="me-2"
                    action=" {{ Auth::check() ? (Auth::user()->type === 'user' ? route('search') : route('admin.search')) : route('search') }} "
                    method="GET">
                    <div class="search-box">
                        <button type="submit" class="nav-link">
                            <i class="fa fa-search"></i>
                        </button>
                        <input class="form-control" type="text" name="keyword" placeholder="Tìm kiếm..."
                            value=" {{ request('keyword') }}">
                    </div>
                </form>

                @auth
                    <div class="dropdown pe-4">
                        <button class="btn btn-outline-secondary position-relative dropdown-toggle" type="button"
                            id="account" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                            @if ($cart_count > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                                </span>
                            @endif
                            </a>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item"
                                    href="{{ Auth::check() ? (Auth::user()->type === 'user' ? route('cart') : route('admin.cart')) : route('cart') }}">Giỏ
                                    hàng
                                    @if ($cart_count > 0)
                                        <span
                                            class="position-absolute top-10 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ $cart_count > 99 ? '99+' : $cart_count }}
                                        </span>
                                    @endif
                                </a>
                            </li>
                            <li><a class="dropdown-item" href="#">Đổi mật khẩu</a></li>
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
                        <a class="nav-link" href="{{ route('login') }}">Đăng nhập</a>
                    @endif
                    <span class="mx-2">|</span>
                    @if (!Route::is('register'))
                        <a class="nav-link" href="{{ route('register') }}">Đăng kí</a>
                    @endif
                @endguest
            </div>
        </div>
    </nav>

    <div class="container-md-fluid container-xxl mt-4">
        @yield('banner')
    </div>

    <!-- Nội dung của từng trang -->
    <div class="container-md-fluid container-xxl mt-4">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts') <!-- Cho phép trang con thêm JS riêng -->
</body>

</html>
