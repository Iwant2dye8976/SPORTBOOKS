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

<div class="row row-cols-auto">
    <div class="col p-0">
        <form action=" {{ Auth::user()->type === 'admin' ? route('admin.user-m.search') : route('home') }} "
            method="GET">
            <div class="search-box">
                <button class="border border-0" type="submit">
                    <i class="fa fa-search"></i>
                </button>
                <input class="form-control" type="search" name="keyword" placeholder="Nhập email..."
                    value="{{ rawurldecode(request('keyword')) }}">
            </div>
        </form>
    </div>
</div>


<div class="mt-4">
    <div class="row row-cols-auto" style="min-height:max-content;">
        <div class="col-12 border border-dark rounded"
            style="background-color: #fffaf0; max-height: 900px; overflow-y: auto;">
            <div class="row row-cols-2 mb-1 pb-4 pt-1 px-1 sticky-top" style="background-color: #fffaf0; z-index: 999;">
                <div class="col">
                    <a href="{{ route('admin.user-m') }}"
                        class="text-start sticky-top fs-2 text-decoration-none text-dark">Quản tài khoản</a>
                </div>
                <div class="col mb-4">
                    <h4 class="text-end text-secondary">{{ $user_count }} tài khoản</h4>
                </div>
                <div class="col-12 row text-center mt-3 fw-bolder">
                    <div class="col-4">
                        <span>Tên người dùng</span>
                    </div>
                    <div class="col-4">
                        <span>Email</span>
                    </div>
                    <div class="col-3">
                        <span>Loại tài khoản</span>
                    </div>
                </div>
                <div class="col-12 mt-1">
                    <hr>
                </div>
            </div>
            @if ($user_count != 0)
                @foreach ($users as $user)
                    <div class="col-12 row book d-flex align-items-center justify-content-center">
                        <div class="col-4 fw-bold">
                            <h5 class="text-center text-break">{{ $user->name }}</h5>
                        </div>
                        <div class="col-4 fw-bold">
                            <h5 class="text-center text-break">{{ $user->email }}</h5>
                        </div>
                        <div class="col-3 fw-bold">
                            <h5 class="text-center">{{ $user->type }}</h5>
                        </div>
                        <div class="col fw-bold">
                            {{-- <a class="text-decoration-none fs-4" href=""
                            onclick="event.preventDefault();
                this.closest('form').submit();"><span
                                class="text text-secondary">X</span></a> --}}
                            <div class="text-center">
                                <a href="#" class="text-decoration-none fs-4" data-bs-toggle="modal"
                                    data-bs-target="#modal-{{ $user->id }}">
                                    <span class="text text-secondary">X</span>
                                </a>
                            </div>
                            <div class="modal fade" id="modal-{{ $user->id }}" tabindex="-1"
                                aria-labelledby="deleteModal" aria-hidden="true" data-bs-backdrop="static">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Xác nhận xóa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-break">
                                            Bạn có chắc muốn xóa người dùng <strong>{{ $user->name }}</strong> không?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Hủy</button>
                                            <form action="{{ route('admin.delete_user', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach
            @else
                <div class="col-12 text-center text-secondary mb-5">
                    KHÔNG TÌM TÀI KHOẢN NÀO
                </div>
            @endif
        </div>
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $users->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
</div>
