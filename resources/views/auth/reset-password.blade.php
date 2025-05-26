<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body style="background: rgb(174,209,239);
background: linear-gradient(103deg, rgba(174,209,239,1) 0%, rgba(185,211,231,1) 16%, rgba(197,214,224,1) 32%, rgba(219,218,208,1) 48%, rgba(219,218,208,1) 63%, rgba(231,221,201,1) 79%);">
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block border border-3 border-dark"
                                style="border-radius: 1rem 0 0 1rem;">
                                <img src="{{ asset('/imgs/datkoi.gif') }}" alt="reset password form"
                                    class="h-100 img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    @if (session('status'))
                                        {{-- @foreach ($errors->all() as $error) --}}
                                        <p class="ps-1 text text-danger fs-5">{{ session('status') }}</p>
                                        {{-- @endforeach --}}
                                    @endif

                                    @foreach ($errors->all() as $error)
                                        <p class="ps-1 text text-danger fs-5">{{ $error }}</p>
                                    @endforeach

                                    <form action="{{ route('password.store') }}" method="POST">
                                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                        @csrf
                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <i class="fas fa-cubes fa-2x mt-1 me-3" style="color: #ff6219;"></i>
                                            <a class="text-decoration-none text-dark" href="{{ route('home') }}"><span
                                                    class="h1 fw-bold mb-0">Đặt lại mật khẩu</span></a>
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="email">Địa chỉ Email</label>
                                            <input type="email" id="email" name="email"
                                                class="form-control form-control-lg"
                                                value="{{ old('email', $request->email) }}" required />
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="email">Mật khẩu</label>
                                            <input type="password" id="password" name="password"
                                                class="form-control form-control-lg" required />
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="email">Xác nhận mật khẩu</label>
                                            <input type="password" id="password_confirmation"
                                                name="password_confirmation" class="form-control form-control-lg"
                                                required />
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-dark btn-lg btn-block" type="submit">Xác
                                                nhận</button>
                                        </div>
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
