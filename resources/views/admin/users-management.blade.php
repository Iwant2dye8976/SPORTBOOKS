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

<div class="row mb-4">
    <div class="col-12">
        <form action="{{ Auth::user()->type === 'admin' ? route('admin.user-m.search') : route('home') }}" method="GET" class="d-flex">
            <input class="form-control me-2" type="search" name="keyword" placeholder="Nhập email..." value="{{ rawurldecode(request('keyword')) }}">
            <button class="btn btn-dark" type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
</div>

<div class="card shadow-sm border-dark">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Quản lý tài khoản</h4>
        <span class="text-secondary">{{ $user_count }} tài khoản</span>
    </div>

    <div class="card-body p-0">
        @if ($user_count != 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center mb-0">
                    <thead class="table-light fw-bold border-bottom">
                        <tr>
                            <th>Tên người dùng</th>
                            <th>Email</th>
                            <th>Loại tài khoản</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <a class="text-dark text-decoration-underline" href="{{ route('admin.user-m.detail', $user->id) }}">
                                        {{ $user->name }}
                                    </a>
                                </td>
                                <td class="text-break">{{ $user->email }}</td>
                                <td>
                                    @switch($user->type)
                                        @case('admin') Quản trị viên @break
                                        @case('deliverer') Người giao hàng @break
                                        @case('user') Khách hàng @break
                                        @default Không xác định
                                    @endswitch
                                </td>
                                <td>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal-{{ $user->id }}" class="text-danger fs-5">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>

                                    <!-- Modal xác nhận xóa -->
                                    <div class="modal fade" id="modal-{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Xác nhận xóa</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Bạn có chắc muốn xóa người dùng <strong>{{ $user->name }}</strong> không?
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('admin.delete_user', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">XÁC NHẬN</button>
                                                    </form>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">HỦY</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End modal -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-5 text-center text-muted">
                KHÔNG TÌM TÀI KHOẢN NÀO
            </div>
        @endif
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $users->appends(request()->query())->links('pagination::bootstrap-4') }}
</div>
