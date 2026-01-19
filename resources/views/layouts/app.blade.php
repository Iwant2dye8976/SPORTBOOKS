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

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
        <div class="container-fluid ps-4">
            <!-- Logo -->
            <a class="navbar-brand fw-bold text-primary fs-2" href="{{ url('/') }}">SPORTBOOKS</a>

            <!-- Toggle button cho mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav menu">
                    <li class="nav-item">
                        <a class="nav-link l" aria-current="page" href="{{ url('/') }}">Trang
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
                        @if (!Auth::user()->hasVerifiedEmail())
                            <span
                                class="position-absolute top-0 translate-middle px-2 bg-danger border border-light rounded-circle text-light">!
                            </span>
                        @endif
                        <ul class="dropdown-menu p-0">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Tài
                                    khoản
                                    @if (!Auth::user()->hasVerifiedEmail())
                                        <span
                                            class="position-absolute start-100 top-10 translate-middle p-1 bg-danger border border-light rounded-circle">
                                        </span>
                                    @endif
                                </a>
                            </li>
                            <hr class="mx-0 mt-0 mb-1">
                            @if (Auth::check() && Auth::user()->type === 'admin')
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.book-m') }}">Quản lý</a>
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

    <div class="mb-4">
        @yield('banner')
    </div>

    <!-- Nội dung của từng trang -->
    <div class="container-md-fluid container-xxl mt-4 px-1 min-vh-100" style="z-index: 999;">
        @yield('content')
    </div>

    <div>
        @include('components.footer')
    </div>
    @include('components.chatbox')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
    <script src="{{ asset('js/alert.js') }}"></script>
    <script src="{{ asset('js/disablebutton.js') }}"></script>
    <script src="{{ asset('js/showAlert.js') }}"></script>
    <script src="{{ asset('js/amountChangeButton.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/starRating.js') }}"></script>
    <script src="{{ asset('js/chatbot.js') }}"></script>

</body>

</html>
