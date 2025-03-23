<div class="mt-4">
    <h2 class="mb-4">Quản lý sách</h2>

    <!-- Nút thêm sách -->
    <div class="text-end">
        <a href="" class="btn btn-success">+ Thêm sách</a>
    </div>
    <!-- Bảng danh sách sách -->
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Ảnh</th>
                <th>Tiêu đề</th>
                <th>Tác giả</th>
                <th>Thể loại</th>
                <th>Mô tả</th>
                <th>Giá</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
                <tr>
                    <td>
                        <img src="{{ $book->image_url ?? 'https://static.kinhtedothi.vn/w960/images/upload/2021/12/24/sach-huan-1.jpg' }}" width="100">
                    </td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->category }}</td>
                    <td>{{ $book->description }}</td>
                    <td>${{ $book->price }}</td>
                    <td>
                        <a href="" class="btn btn-primary btn-sm">Sửa</a>
                        <form action="" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-4">
        {{ $books->links('pagination::bootstrap-4') }}
    </div>
</div>
