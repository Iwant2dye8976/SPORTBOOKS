<div class="mb-5">
    <a class="text text-decoration-none text-dark fs-4" href="{{ url('admin/index/bookmanagement') }}">
        <i class="fas fa-arrow-left"></i> Quay lại
    </a>

    @if (session('success'))
        <div class="row alert alert-success mt-2" id="success-alert">
            <p class="text-center p-0 m-0">{{ session('success') }}</p>
        </div>
    @endif
    @if (session('error'))
        <div class="row alert alert-danger mt-2" id="error-alert">
            <p class="text-center p-0 m-0">{{ session('error') }}</p>
        </div>
    @endif

    <div class="row d-flex justify-content-center align-items-center border border-dark border-1 rounded p-5 mt-4">
        <div class="text text-center col">
            <h4>Xem trước</h4>
            <img id="preview" class="img_fluid" height="500" width="500" src="{{ $book->image_url }}"
                alt="Xem trước">
        </div>
        <div class="col">
            <form action="{{ route('admin.book-m.update', $book->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label class="form-label" for="image_url">Đường dẫn ảnh</label>
                    <input class="form-control" id="image_url" name="image_url" type="text"
                        value="{{ $book->image_url }}" onblur="updateImage();">
                    @error('image_url')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="title">Tiêu đề</label>
                    <input class="form-control" id="title" name="title" type="text"
                        value="{{ $book->title }}">
                    @error('title')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="author">Tác giả</label>
                    <input class="form-control" id="author" name="author" type="text"
                        value="{{ $book->author }}">
                    @error('author')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="category">Thể loại</label>
                    <input class="form-control" id="category" name="category" type="text"
                        value="{{ $book->category }}">
                    @error('category')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="price">Giá bán</label>
                    <input class="form-control" id="price" name="price" type="number" step="0.01"
                        min="1" value="{{ $book->price }}">
                    @error('price')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="description">Mô tả sách</label>
                    <textarea class="form-control" name="description" id="description" cols="30" rows="5">{{ $book->description }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-dark form-control">Xác nhận</button>
            </form>
        </div>
    </div>
</div>
<script>
    function updateImage() {
        let preview_image = document.getElementById('preview');
        let image_url = document.getElementById('image_url').value;
        preview_image.setAttribute('src', image_url);
    }
</script>
