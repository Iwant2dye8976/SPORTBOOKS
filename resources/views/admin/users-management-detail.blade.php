@if (session('error'))
    <div class="container-fluid alert alert-danger text-center" id="error-alert">
        <p class="p-0 m-0">{{ session('error') }}</p>
    </div>
@endif
@if (session('success'))
    <div class="container-fluid row alert alert-success text-center" id="success-alert">
        <p class="p-0 m-0">{{ session('success') }}</p>
    </div>
@endif

<a class="text text-decoration-none text-dark fs-4" href="{{ url('admin/usermanagement') }}">
    <i class="fas fa-arrow-left"></i> Quay lại
</a>

<div class="col-12 p-4 mt-3 border border-dark rounded">
    <h4 class="fw-bold">Thông tin cơ bản</h4>
    <p class="text text-secondary">Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
    <hr>
    @switch($user->type)
        @case('user')
            <div class="mb-3 row">
                <h5 class="{{ $user->hasVerifiedEmail() ? 'text-primary' : 'text-warning' }}">
                    {{ $user->hasVerifiedEmail() ? 'Tài khoản này đã được xác minh.' : 'Tài khoản này chưa được xác minh.' }}
                </h5>
            </div>
        @break

        @default
    @endswitch

    <div class="mb-3 row">
        <label class="align-self-center col-3 text-end me-3" for="name">Họ và tên:</label>
        <div class="col-6">
            <input class="form-control" id="name" type="text" name="name" value="{{ $user->name }}"
                autocomplete="name" readonly>
        </div>
    </div>
    <div class="mb-3 row">
        <label class="align-self-center col-3 text-end me-3" for="email">Email đăng nhập:</label>
        <div class="col-6">
            <input class="form-control" id="email" type="email" name="email" value="{{ $user->email }}"
                readonly>
        </div>
    </div>
    <div class="mb-3 row">
        <label class="align-self-center col-3 text-end me-3" for="phone_number">Số điện thoại:</label>
        <div class="col-6">
            <input class="form-control" id="phone_number" type="tel" name="phone_number"
                value="{{ $user->phone_number }}" readonly>
        </div>
    </div>
    <div class="mb-3 row">
        <label class="align-self-center col-3 text-end me-3" for="address">Địa chỉ:</label>
        <div class="col-6">
            <input class="form-control" id="address" type="text" name="address" value="{{ $user->address }}"
                readonly>
        </div>
    </div>
    <div class="mb-3 row">
        <label class="align-self-center col-3 text-end me-3" for="account-type">Loại tài khoản:</label>
        <div class="col-6">
            <input class="form-control" id="account-type"
                value="{{ ($user->type === 'user' ? 'Khách hàng' : $user->type === 'admin') ? 'Quản trị viên' : 'Người giao hàng' }}"
                readonly>
        </div>
    </div>
    @if (Auth::user()->type === 'deliverer')
        <div class="mb-3 row">
            <label class="align-self-center col-3 text-end me-3" for="dcount">Số đơn hàng đã được vận chuyển:</label>
            <div class="col-6">
                <input class="form-control" id="dcount" type="number" value="{{ $d_count > 0 ? $d_count : 0 }}"
                    readonly>
            </div>
        </div>
    @endif
</div>
