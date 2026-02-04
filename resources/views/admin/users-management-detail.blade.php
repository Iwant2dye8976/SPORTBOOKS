@if (session('error'))
    <div class="alert alert-danger text-center" id="error-alert">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success text-center" id="success-alert">
        {{ session('success') }}
    </div>
@endif

<div class="mb-4">
    <a class="text-decoration-none text-dark fs-5" href="{{ url('admin/usermanagement') }}">
        <i class="fas fa-arrow-left me-1"></i> Quay lại
    </a>
</div>

<div class="card border-dark shadow-sm">
    <div class="card-header bg-light">
        <h4 class="fw-bold mb-0">Thông tin người dùng</h4>
        <p class="text-muted mb-0">Quản lý hồ sơ để bảo mật tài khoản</p>
    </div>

    <div class="card-body">
        @switch($user->type)
            @case('user')
                <div class="alert {{ $user->hasVerifiedEmail() ? 'alert-primary' : 'alert-warning' }}">
                    {{ $user->hasVerifiedEmail() ? 'Tài khoản này đã được xác minh.' : 'Tài khoản này chưa được xác minh.' }}
                </div>
                @break
        @endswitch

        <div class="row mb-3">
            <label class="col-md-3 text-end fw-semibold">Họ và tên:</label>
            <div class="col-md-6">
                <input class="form-control" type="text" value="{{ $user->name }}" readonly>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-md-3 text-end fw-semibold">Email đăng nhập:</label>
            <div class="col-md-6">
                <input class="form-control" type="email" value="{{ $user->email }}" readonly>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-md-3 text-end fw-semibold">Số điện thoại:</label>
            <div class="col-md-6">
                <input class="form-control" type="text" value="{{ $user->phone_number }}" readonly>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-md-3 text-end fw-semibold">Địa chỉ:</label>
            <div class="col-md-6">
                <input class="form-control" type="text" value="{{ $user->address }}" readonly>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-md-3 text-end fw-semibold">Loại tài khoản:</label>
            <div class="col-md-6">
                <input class="form-control" type="text"
                    value="{{ $user->type === 'user' ? 'Khách hàng' : ($user->type === 'admin' ? 'Quản trị viên' : 'Người giao hàng') }}"
                    readonly>
            </div>
        </div>

        @if (Auth::user()->type === 'deliverer')
            <div class="row mb-3">
                <label class="col-md-3 text-end fw-semibold">Đơn hàng đã giao:</label>
                <div class="col-md-6">
                    <input class="form-control" type="number" value="{{ $d_count > 0 ? $d_count : 0 }}" readonly>
                </div>
            </div>
        @endif
    </div>
</div>
