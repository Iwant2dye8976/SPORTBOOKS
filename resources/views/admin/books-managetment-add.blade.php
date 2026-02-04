<div class="container mb-5">
    <a class="text-decoration-none text-dark fs-5" href="{{ url('admin/bookmanagement') }}">
        <i class="fas fa-arrow-left me-2"></i> Quay lại
    </a>

    @if (session('success'))
        <div class="alert alert-success mt-3 text-center" id="success-alert">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger mt-3 text-center" id="error-alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="card mt-4 shadow rounded">
        <div class="card-body">
            <div class="row g-4">
                {{-- Preview ảnh --}}
                <div class="col-md-5 text-center">
                    <h5 class="mb-3">Xem trước</h5>
                    <img id="preview" class="img-fluid rounded border" style="max-height: 450px;" src="" alt="Xem trước">
                </div>

                {{-- Form nhập --}}
                <div class="col-md-7">
                    <form action="{{ route('admin.book-m.store') }}" method="POST" onsubmit="disableButton()">
                        @csrf

                        <div class="mb-3">
                            <label for="image_url" class="form-label">Đường dẫn ảnh</label>
                            <input type="text" name="image_url" id="image_url" class="form-control"
                                   onblur="updateImage();" value="{{ old('image_url') }}">
                            @error('image_url') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu đề</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label">Tác giả</label>
                            <input type="text" name="author" id="author" class="form-control" value="{{ old('author') }}">
                            @error('author') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Thể loại</label>
                            <select name="category" id="category" class="form-select">
                                @foreach (['Tình cảm', 'Tâm lý', 'Tài chính', 'Thể thao'] as $genre)
                                    <option value="{{ $genre }}" {{ old('category') === $genre ? 'selected' : '' }}>{{ $genre }}</option>
                                @endforeach
                            </select>
                            @error('category') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="origin_price" class="form-label">Giá gốc</label>
                            <input type="number" step="0.1" min="1" max="9999" name="origin_price" id="origin_price"
                                   class="form-control" value="{{ old('origin_price', 1) }}" onblur="updateFinalPrice()">
                            @error('origin_price') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="discount" class="form-label">Giá giảm (nếu có)</label>
                            <input type="number" step="1" min="0" max="100" name="discount" id="discount"
                                   class="form-control" value="{{ old('discount', 0) }}" onblur="updateFinalPrice()">
                            @error('discount') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="final_price" class="form-label">Giá bán</label>
                            <input type="number" step="0.1" min="1" max="9999" name="final_price" id="final_price"
                                   class="form-control" value="{{ old('final_price', 1) }}" disabled>
                            @error('final_price') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="stock" class="form-label">Số lượng tồn kho</label>
                            <input type="number" min=1 name=stock id=stock
                                   class=form-control value="{{ old('stock', 1) }}">
                            @error('stock') <small class=text-danger>{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả sách</label>
                            <textarea name="description" id="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <button type="submit" id="submit-button" class="btn btn-dark w-100">Xác nhận</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
