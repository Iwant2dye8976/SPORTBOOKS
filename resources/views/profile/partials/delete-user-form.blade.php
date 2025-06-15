@php
    switch (Auth::user()->type) {
        case 'admin':
            $actionRoute = route('admin.profile.destroy');
            break;
        case 'deliverer':
            $actionRoute = route('delivery.profile.destroy');
            break;
        default:
            $actionRoute = route('profile.destroy');
            break;
    }
@endphp
<div class="col-12">
    <div class="border border-danger rounded p-4">
        @if (!Auth::user()->hasVerifiedEmail())
            <h4>Tài khoản của bạn chưa được xác minh</h4>
            <p>Để tiếp tục hành động này, vui lòng <span><a href="{{ route('verification.notice') }}"
                        class="text text-decoration-underline">xác minh tài khoản của bạn.</a></span></p>
        @else
            <h4 class="fw-bold text-danger mb-3">XÓA TÀI KHOẢN</h4>

            <p class="text-dark mb-1">Bạn có chắc chắn muốn xóa tài khoản của mình không?</p>
            <p class="text-dark mb-1">
                Khi tài khoản bị xóa, <strong class="text-danger">tất cả tài nguyên và dữ liệu sẽ bị xóa vĩnh
                    viễn</strong>.
            </p>
            <p class="text-dark mb-3">
                Vui lòng nhập mật khẩu để xác nhận bạn muốn <strong class="text-danger">xóa tài khoản vĩnh viễn</strong>.
            </p>
            <hr>
            <form method="POST" action="{{ $actionRoute }}">
                @csrf
                @method('DELETE')

                <div class="mb-3 row">
                    <label for="password" class="align-self-center col-3 text-end me-3">Mật khẩu:</label>
                    <div class="col" style="max-width: 300px;">
                        <input id="password" name="password" type="password" class="form-control"
                            placeholder="Nhập mật khẩu xác nhận" autocomplete="current-password">

                        @if ($errors->userDeletion->has('password'))
                            <div class="mt-2 text-danger">
                                {{ $errors->userDeletion->first('password') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="text text-center">
                    <button type="button" class="btn btn-danger form-control" data-bs-toggle="modal"
                        data-bs-target="#confirmDeleteModal" style="max-width: 500px;">
                        XÁC NHẬN
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
                    aria-hidden="true" data-bs-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-danger fw-bold" id="confirmDeleteModalLabel">CẢNH BÁO</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Đóng"></button>
                            </div>
                            <div class="modal-body text-center">
                                Bạn có chắc chắn muốn <strong class="text-danger">xóa tài khoản</strong>?<br>
                                Hành động này <strong class="text-danger">không thể hoàn tác!</strong>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">HỦY</button>
                                <button type="submit" class="btn btn-danger">XÓA</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>
