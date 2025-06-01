<div class="col-12 p-4 border border-dark rounded">
    <h4 class="fw-bold">Đổi mật khẩu</h4>
    <p class="text text-secondary">Thay đổi mật khẩu để bảo mật tài khoản của bạn</p>
    <hr>
    <form class="mt-4" action="{{ route('password.update') }}" method="POST" onsubmit="disableButton();">
        @method('PUT')
        @csrf
        <div class="mb-3 row">
            <label class="align-self-center col-3 text-end me-3" for="current_password">Mật khẩu hiện tại:</label>
            <div class="col" style="max-width: 300px;">
                <input class="form-control" id="current_password" type="password" name="current_password" autocomplete="current-password">
                @if ($errors->updatePassword->has('current_password'))
                    <div class="text-danger mt-1">{{ $errors->updatePassword->first('current_password') }}</div>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label class="align-self-center col-3 text-end me-3" for="new_password">Mật khẩu mới:</label>
            <div class="col" style="max-width: 300px;">
                <input class="form-control" id="new_password" type="password" name="password" autocomplete="new-password">
                @if ($errors->updatePassword->has('password'))
                    <div class="text-danger mt-1">{{ $errors->updatePassword->first('password') }}</div>
                @endif
            </div>
        </div>
        <div class="mb-3 row">
            <label class="align-self-center col-3 text-end me-3" for="password_confirmation">Xác nhận mật khẩu:</label>
            <div class="col" style="max-width: 300px;">
                <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password">
                @if ($errors->updatePassword->has('password_confirmation'))
                    <div class="text-danger mt-1">{{ $errors->updatePassword->first('password_confirmation') }}</div>
                @endif
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary form-control" id="submit-button" style="max-width: 300px;">
                Xác nhận
            </button>
        </div>
    </form>
</div>
