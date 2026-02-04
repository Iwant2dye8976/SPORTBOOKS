<div class="mb-5">
    <a class="text text-decoration-none text-dark fs-4" href="{{ url('admin/bookmanagement') }}">
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

    <div class="card mt-4 shadow rounded">
        <div class="card-body">
            <div class="row g-4">
                {{-- Preview ảnh --}}
                <div class="col-md-5 text-center">
                    <h5 class="mb-3">Xem trước</h5>
                    <img id="preview" class="img-fluid rounded border" style="max-height: 450px;" src=""
                        alt="Xem trước">
                </div>

                {{-- Form nhập --}}
                <div class="col">
                    <form action="{{ route('admin.book-m.update', $book->id) }}" method="POST"
                        onsubmit="disableButton()">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="form-label" for="image_url">Đường dẫn ảnh</label>
                            <input class="form-control" id="image_url" name="image_url" type="text"
                                value="{{ old('image_url', $book->image_url) }}" onblur="updateImage();">
                            @error('image_url')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="title">Tiêu đề</label>
                            <input class="form-control" id="title" name="title" type="text"
                                value="{{ old('title', $book->title) }}">
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="author">Tác giả</label>
                            <input class="form-control" id="author" name="author" type="text"
                                value="{{ old('author', $book->author) }}">
                            @error('author')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="category">Thể loại</label>
                            {{-- <input class="form-control" id="category" name="category" type="text"
                        value="{{ $book->category }}"> --}}
                            <select class="form-select" name="category" id="category">
                                <option value="Tình cảm"
                                    {{ old('category', $book->category) === 'Tình cảm' ? 'selected' : '' }}>Tình cảm
                                </option>
                                <option value="Tâm lý"
                                    {{ old('category', $book->category) === 'Tâm lý' ? 'selected' : '' }}>
                                    Tâm lý</option>
                                <option value="Tài chính"
                                    {{ old('category', $book->category) === 'Tài chính' ? 'selected' : '' }}>Tài chính
                                </option>
                                <option value="Thể thao"
                                    {{ old('category', $book->category) === 'Thể thao' ? 'selected' : '' }}>Thể thao
                                </option>
                            </select>
                            @error('category')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="origin_price" class="form-label">Giá gốc</label>
                            <input type="number" step="0.1" min="1" max="9999" name="origin_price"
                                id="origin_price" class="form-control"
                                value="{{ old('origin_price', $book->origin_price) }}" onblur="updateFinalPrice()">
                            @error('origin_price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="discount" class="form-label">Giá giảm (nếu có)</label>
                            <input type="number" step="1" min="0" max="100" name="discount"
                                id="discount" class="form-control" value="{{ old('discount', $book->discount) }}"
                                onblur="updateFinalPrice()">
                            @error('discount')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="final_price" class="form-label">Giá bán</label>
                            <input type="number" step="0.1" min="1" max="9999" name="final_price"
                                id="final_price" class="form-control"
                                value="{{ old('final_price', $book->final_price) }}" disabled>
                            @error('final_price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="stock" class="form-label">Số lượng tồn kho</label>
                            <input type="number" min=1 name=stock id=stock class=form-control
                                value="{{ old('stock', $book->stock) }}">
                            @error('stock')
                                <small class=text-danger>{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="description">Mô tả sách</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="5">{{ old('description', $book->description) }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button id="submit-button" type="submit" class="btn btn-dark form-control">Xác nhận</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
