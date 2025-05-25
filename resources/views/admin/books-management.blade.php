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
    <div class="col-6 p-0">
        <form action=" {{ Auth::user()->type === 'admin' ? route('admin.book-m.search') : route('home') }} "
            method="GET">
            <div class="search-box">
                <button class="border border-0" type="submit">
                    <i class="fa fa-search"></i>
                </button>
                <input class="form-control" type="search" name="keyword" placeholder="Tìm kiếm..."
                    value="{{ rawurldecode(request('keyword')) }}">
            </div>
        </form>
    </div>
    <div class="col-6 text-end">
        <a class="mt-5 mb-3 text text-decoration-none text-dark fs-4" href="{{ route('admin.book-m.add') }}"><i
                class="fa-solid fa-circle-plus me-1 text-primary"></i>Thêm sách mới</a>
    </div>
</div>


<div class="mt-4">
    <div class="row row-cols-auto" style="min-height:max-content;">
        <div class="col-12 border border-dark rounded"
            style="background-color: #fffaf0; max-height: 900px; overflow-y: auto;">
            <div class="row row-cols-2 mb-1 pb-4 pt-2 px-1 sticky-top" style="background-color: #fffaf0; z-index: 999;">
                <div class="col">
                    <a href="{{ route('admin.book-m') }}"
                        class="text-start sticky-top fs-2 text-decoration-none text-dark">Quản lý sách</a>
                </div>
                <div class="col mb-4">
                    <h4 class="text-end text-secondary">{{ $book_count }} sản phẩm</h4>
                </div>
                <div class="col-12 row text-center mt-3 fw-bolder">
                    <div class="col-2">
                        <span>Ảnh</span>
                    </div>
                    <div class="col-2">
                        <span>Tiêu đề sách</span>
                    </div>
                    <div class="col-1">
                        <span>Thể loại</span>
                    </div>
                    <div class="col-1">
                        <span>Giá</span>
                    </div>
                    <div class="col-4">
                        <span>Mô tả</span>
                    </div>
                </div>
                <div class="col-12 mt-1">
                    <hr>
                </div>
            </div>
            @if ($book_count != 0)
                @foreach ($books as $book)
                    <div class="col-12 d-flex align-items-center row book">
                        <div class="col-2 text-center">
                            <img class="img-fluid" width="200" src="{{ $book->image_url }}"
                                alt="{{ $book->title }}">
                        </div>
                        <div class="col-2 text-center">
                            <h5>{{ $book->title }}</h5>
                        </div>
                        <div class="col-1 text-center">
                            <h5>{{ $book->category }}</h5>
                        </div>
                        <div class="col-1 text-center">
                            <h5>${{ $book->price }}</h5>
                        </div>
                        <div class="col-4 text-center">
                            <h5 style="max-height: 217px; overflow-y: auto;">{{ $book->description }}</h5>
                        </div>
                        <div class="col-1 text-center">
                            <h5>
                                <a href="{{ route('admin.book-m.detail', $book->id) }}"
                                    class="text text-decoration-none text-secondary">Sửa</a>
                            </h5>
                        </div>
                        <div class="col-1 text-center fw-bold">
                            <a href="#" class="text-decoration-none fs-4" data-bs-toggle="modal"
                                data-bs-target="#modal-{{ $book->id }}">
                                <span class="text text-secondary">X</span>
                            </a>
                            <div class="modal fade" id="modal-{{ $book->id }}" tabindex="-1"
                                aria-labelledby="deleteModal" aria-hidden="true" data-bs-backdrop="static">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">XÓA SÁCH</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-break">
                                            Bạn có chắc muốn xóa sách <strong>{{ $book->title }}</strong> không?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">HỦY</button>
                                            <form action="{{ route('admin.book-m.delete', $book->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">XÓA</button>
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
                    KHÔNG TÌM THẤY SẢN PHẨM
                </div>
            @endif
        </div>
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $books->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
</div>
