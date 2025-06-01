@extends('layouts.admin')

@section('title', 'Thông tin tài khoản')

@section('content')
    {{-- <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item fs-4"><a href="{{ route('home') }}">Trang chủ</a></li>
            <li class="breadcrumb-item fs-4 active" aria-current="page">Giỏ hàng</li>
        </ol>
    </nav> --}}
    <div class="mt-5">
        @if (session('status'))
            <div class="alert alert-success text-center" id="status">
                {{ session('status') }}
            </div>
        @endif
        <div class="row row-cols-auto">
            <div class="col-12">
                <h2 class="fw-bold">Tài khoản của bạn</h2>
                <hr>
            </div>

            <div class="col-12 ps-2 py-3">
                <h4 class="fw-bold text-secondary">Thông tin cơ bản</h4>
                <form class="w-25"
                    action="{{ Auth::user()->type === 'admin' ? route('admin.profile.update') : route('profile.update') }}"
                    method="POST">
                    @method('patch')
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="name">Họ và tên</label>
                        <input class="form-control" id="name" type="text" name="name"
                            value="{{ Auth::user()->name }}" autocomplete="name">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control" id="email" type="email" name="email"
                            value="{{ Auth::user()->email }}">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="phone_numner">Số điện thoại</label>
                        <input class="form-control" id="phone_numner" type="tel" name="phone_number"
                            value="{{ Auth::user()->phone_number }}">
                        @error('phone_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="address">Địa chỉ</label>
                        <input class="form-control" id="address" type="text" name="address"
                            value="{{ Auth::user()->address }}">
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-outline-primary form-control">
                        Xác nhận
                    </button>
                </form>
                <hr>
            </div>

            <div class="col-12 ps-2 py-3">
                <h4 class="fw-bold text-secondary">Đổi mật khẩu</h4>
                <form class="w-25" action="{{ route('password.update') }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="current_password">Mật khẩu hiện tại</label>
                        <input class="form-control" id="current_password" type="password" name="current_password"
                            autocomplete="current_password">
                        @if ($errors->updatePassword->has('current_password'))
                            <div class="mt-2 text-danger">
                                {{ $errors->updatePassword->first('current_password') }}
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="new_password">Mật khẩu mới</label>
                        <input class="form-control" id="new_password" type="password" name="password"
                            autocomplete="new_password">
                        @if ($errors->updatePassword->has('password'))
                            <div class="mt-2 text-danger">
                                {{ $errors->updatePassword->first('password') }}
                            </div>
                        @endif

                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password_confirmation">Xác nhận lại mật khẩu mới</label>
                        <input class="form-control" id="password_confirmation" type="password" name="password_confirmation"
                            autocomplete="password_confirmation">
                        @if ($errors->updatePassword->has('password_confirmation'))
                            <div class="mt-2 text-danger">
                                {{ $errors->updatePassword->first('password_confirmation') }}
                            </div>
                        @endif

                    </div>
                    <button class="btn btn-outline-primary form-control">
                        Xác nhận
                    </button>
                </form>
                <hr>
            </div>
            <div class="col-12 ps-2 py-3">
                <div class="w-25">
                    <h4 class="fw-bold text-danger">XÓA TÀI KHOẢN</h4>
                    {{-- <h3 class="text text-center text-secondary">Đổi mật khẩu</h3> --}}
                    <h5 class="text text-dark">Bạn có chắc chắn muốn xóa tài khoản của mình không?</h5>
                    <h6 class="text text-dark">Khi tài khoản của bạn bị xóa, <strong class="text text-danger">tất cả tài
                            nguyên và dữ liệu của nó sẽ bị xóa
                            vĩnh viễn.</strong> Vui lòng nhập mật khẩu của bạn để xác nhận rằng bạn muốn <strong
                            class="text text-danger">xóa tài khoản của mình vĩnh viễn.</strong>
                    </h6>
                </div>
                <form class="w-25" method="POST"
                    action="{{ Auth::user()->type === 'admin' ? route('admin.profile.destroy') : route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')
                    <div class="mb-3">
                        <div class="mb-3">
                            <label class="form-label" for="password">Mật khẩu</label>
                            <input class="form-control" id="password" type="password" name="password"
                                autocomplete="password">
                            @if ($errors->userDeletion->has('password'))
                                <div class="mt-2 text-danger">
                                    {{ $errors->userDeletion->first('password') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <a class="btn btn-danger form-control" data-bs-toggle="modal" data-bs-target="#modal">
                        XÁC NHẬN
                    </a>
                    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="deleteModal"
                        aria-hidden="true" data-bs-backdrop="static">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-danger">CẢNH BÁO</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-break">
                                    Bạn có chắc chắn muốn <strong class="text text-danger">xóa tài khoản</strong>. Hành
                                    động này <strong class="text text-danger">không thể hoàn tác!</strong>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">HỦY</button>
                                    <button type="submit" class="btn btn-danger">XÓA</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
