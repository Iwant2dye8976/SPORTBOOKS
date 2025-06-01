@php
    switch (Auth::user()->type) {
        case 'admin':
            $actionRoute = route('admin.profile.update');
            break;
        case 'deliverer':
            $actionRoute = route('delivery.profile.update');
            break;
        default:
            $actionRoute = route('profile.update');
            break;
    }
@endphp
<div class="col-12 p-4 border border-dark rounded">
    <h4 class="fw-bold">Thông tin cơ bản</h4>
    <p class="text text-secondary">Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
    <hr>
    <form class="mt-4" action="{{ $actionRoute }}" method="POST" onsubmit="disableButton();">
        @method('patch')
        @csrf
        <div class="mb-3 row">
            <label class="align-self-center col-3 text-end me-3" for="name">Họ và tên:</label>
            <div class="col" style="max-width: 300px;">
                <input class="form-control" id="name" type="text" name="name"
                    value="{{ Auth::user()->name }}" autocomplete="name">
                @error('name')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="mb-3 row">
            <label class="align-self-center col-3 text-end me-3" for="email">Email đăng nhập:</label>
            <div class="col" style="max-width: 300px;">
                <input class="form-control" id="email" type="email" name="email"
                    value="{{ Auth::user()->email }}">
                @error('email')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="mb-3 row">
            <label class="align-self-center col-3 text-end me-3" for="phone_number">Số điện thoại:</label>
            <div class="col" style="max-width: 300px;">
                <input class="form-control" id="phone_number" type="tel" name="phone_number"
                    value="{{ Auth::user()->phone_number }}">
                @error('phone_number')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="mb-3 row">
            <label class="align-self-center col-3 text-end me-3" for="address">Địa chỉ:</label>
            <div class="col" style="max-width: 300px;">
                <input class="form-control" id="address" type="text" name="address"
                    value="{{ Auth::user()->address }}">
                @error('address')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary form-control" id="submit-button"
                style="max-width: 300px;">
                Xác nhận
            </button>
        </div>
    </form>
</div>
