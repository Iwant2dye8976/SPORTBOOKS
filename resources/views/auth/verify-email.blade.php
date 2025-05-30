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
            <h4 class="card-title mb-3">Xác minh địa chỉ email của bạn</h4>
            <p class="mb-4">
                Trước khi tiếp tục, vui lòng kiểm tra email để xác minh địa chỉ. Nếu bạn không nhận được email,
                bạn có thể yêu cầu gửi lại.
            </p>

            <p class="mb-4 fw-bold">
                Email của bạn: {{ Auth::user()->email }}
            </p>

            <form method="POST" action="{{ route('verification.send') }}" onsubmit="disableButton();">
                @csrf
                <button id="submit-button" type="submit" class="btn btn-primary w-100">
                    Gửi email xác minh
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="btn btn-outline-secondary w-100">
                    Đăng xuất
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
