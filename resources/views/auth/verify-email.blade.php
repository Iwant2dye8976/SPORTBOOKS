@extends('layouts.app')

@section('content')
@if (session('status') == 'verification-link-sent')
<div id="success-alert" class="alert alert-success text-center" role="alert">
    Một liên kết xác minh mới đã được gửi tới email của bạn.
</div>
@endif
<div class="container mt-5">
    <div class="card mx-auto" style="max-width: 500px;">
        <div class="card-body text-center">
            <h4 class="card-title mb-3">Xác minh tài khoản</h4>
            <span><i class="fa-solid fa-shield fs-2"></i></span>
            <p class="my-4">
                Để tăng cường bảo mật cho tài khoản của bạn, hãy xác minh email của bạn.
            </p>

            <p class="mb-4 fw-bold">
                Email của bạn: {{ Auth::user()->email }}
            </p>

            <form method="POST" action="{{ route('verification.send') }}" onsubmit="disableSubmitButton2(event);">
                @csrf
                <button id="submit-button" type="submit" class="btn btn-primary w-100">
                    Gửi email xác minh
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="mt-3" onsubmit="disableSubmitButton2(event);">
                @csrf
                <button type="submit" class="btn btn-outline-secondary w-100">
                    Đăng xuất
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
