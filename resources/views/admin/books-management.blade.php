<div class="container">
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

    <div class="row mb-3 align-items-center">
        <div class="col-md-6">
            <form action="{{ Auth::user()->type === 'admin' ? route('admin.book-m.search') : route('home') }}" method="GET" class="d-flex">
                <input class="form-control me-2" type="search" name="keyword" placeholder="Tìm kiếm..."
                    value="{{ rawurldecode(request('keyword')) }}">
                <button class="btn btn-primary" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </div>
        <div class="col-md-6 text-end">
            <a class="btn btn-success" href="{{ route('admin.book-m.add') }}">
                <i class="fa-solid fa-circle-plus me-1"></i> Thêm sách mới
            </a>
        </div>
    </div>

    <h4 class="text-muted mb-4">{{ $book_count }} sản phẩm</h4>

    @if ($book_count != 0)
        <div class="row row-cols-1 g-3">
            @foreach ($books as $book)
                <div class="col">
                    <div class="card shadow-sm rounded p-3">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-2 text-center">
                                <img src="{{ $book->image_url }}" alt="{{ $book->title }}" class="img-fluid rounded" style="max-height: 180px;">
                            </div>
                            <div class="col-md-10">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h5 class="fw-bold" style="width: 90%">{{ $book->title }}</h5>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.book-m.detail', $book->id) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fa fa-pen"></i> Sửa
                                        </a>
                                        <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-{{ $book->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <p class="mb-1"><strong>Thể loại:</strong> {{ $book->category }}</p>
                                <p class="mb-1"><strong>Giá:</strong> {{ number_format(ceil($book->final_price * 25000), 0, ',', '.') }}đ</p>
                                <p class="mb-0 text-muted" style="max-height: 70px; overflow-y: auto;">
                                    {{ $book->description }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Xoá --}}
                    <div class="modal fade" id="modal-{{ $book->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Xoá sách</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    Bạn có chắc muốn xoá <strong>{{ $book->title }}</strong>?
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('admin.book-m.delete', $book->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Xác nhận</button>
                                    </form>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $books->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    @else
        <div class="text-center text-muted my-5">
            KHÔNG TÌM THẤY SẢN PHẨM
        </div>
    @endif
</div>
