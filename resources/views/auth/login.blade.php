<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body style="background-color: #9A616D;">
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block border border-3 border-dark" style="border-radius: 1rem 0 0 1rem;">
                                <img src="{{ asset('/imgs/datkoi.gif') }}"
                                    alt="login form" class="h-100 img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form action="{{ route('login') }}" method="POST">
                                        @csrf
                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <i class="fas fa-cubes fa-2x mt-1 me-3" style="color: #ff6219;"></i>
                                            <a class="text-decoration-none text-dark" href="{{ route('home') }}"><span class="h1 fw-bold mb-0">SPORTBOOKS</span></a>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="email">Địa chỉ Email</label>
                                            <input type="email" id="email" name="email"
                                                class="form-control form-control-lg" required />
                                            @if ($errors->any())

                                                @foreach ($errors->all() as $error)
                                                    <p class="ps-1 text text-danger">{{ $error }}</p>
                                                @endforeach

                                            @endif
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="password">Mật khẩu</label>
                                            <input type="password" id="password" name="password"
                                                class="form-control form-control-lg" required />
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-dark btn-lg btn-block" type="submit">Đăng
                                                nhập</button>
                                        </div>

                                        <a class="small text-muted" href="{{route('password.request')}}">Quên mật khẩu?</a>
                                        <p class="mb-5 pb-lg-2" style="color: #393f81;">
                                            Chưa có tài khoản? <a href="{{ route('register') }}"
                                                style="color: #393f81;">Đăng kí tài khoản tại đây</a>
                                        </p>
                                        <a href="#" class="small text-muted">Terms of use.</a>
                                        <a href="#" class="small text-muted">Privacy policy</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
