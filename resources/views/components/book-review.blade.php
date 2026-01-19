<div class="row mt-5">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <ul class="nav nav-tabs border-bottom" id="bookTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active px-4 py-3" id="description-tab" data-bs-toggle="tab"
                            data-bs-target="#description" type="button" role="tab">
                            <i class="fa-solid fa-book-open me-2"></i>
                            Mô tả sản phẩm
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-4 py-3" id="reviews-tab" data-bs-toggle="tab"
                            data-bs-target="#reviews" type="button" role="tab">
                            <i class="fa-solid fa-star me-2"></i>
                            Đánh giá ({{ $reviews_count }})
                        </button>
                    </li>
                </ul>

                <div class="tab-content p-4" id="bookTabsContent">
                    <!-- Tab Mô tả -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                        <div class="description-content" style="line-height: 1.8;">
                            <p class="text-muted">{{ $book->description }}</p>
                        </div>
                    </div>

                    <!-- Tab Đánh giá -->
                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                        <div class="row mb-5">
                            <div class="col-12 col-md-4 text-center mb-4 mb-md-0">
                                <div class="p-4 rounded" style="background-color: #fffaf0;">
                                    <h1 class="display-3 fw-bold text-warning mb-2">{{ $book->avgRating() }}</h1>
                                    <div class="text-warning fs-4 mb-2">
                                        {!! $htmlRatingStars !!}
                                    </div>
                                    <p class="text-muted mb-0">{{ $reviews_count }} đánh giá</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-8">
                                <div class="rating-bars">
                                    @for ($star = 5; $star >= 1; $star--)
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="me-2">
                                                {{ $star }}
                                                <i class="fa-solid fa-star text-warning small"></i>
                                            </span>

                                            <div class="progress flex-grow-1 me-3" style="height: 10px;">
                                                <div class="progress-bar bg-warning"
                                                    style="width: {{ $ratingStats[$star]['percent'] }}%">
                                                </div>
                                            </div>

                                            <span class="text-muted">
                                                {{ $ratingStats[$star]['percent'] }}%
                                            </span>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>

                        <!-- Form đánh giá -->
                        <div class="card border-0 shadow-sm mb-5">
                            <div class="card-body">
                                <h5 class="fw-bold mb-4">
                                    <i class="fa-solid fa-pen-to-square me-2 text-primary"></i>
                                    Viết đánh giá của bạn
                                </h5>

                                @auth
                                    <form action="{{ route('book.review') }}" method="POST">
                                        @csrf

                                        <!-- Chọn số sao -->
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Đánh giá sao</label>
                                            <div class="rating-stars d-flex gap-2 fs-4 text-warning">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <input type="radio" name="rating" value="{{ $i }}"
                                                        id="star{{ $i }}" hidden required>
                                                    <label for="star{{ $i }}" style="cursor:pointer;">
                                                        <i class="fa-regular fa-star"></i>
                                                    </label>
                                                @endfor
                                            </div>
                                        </div>
                                        <input type="number" name="book_id" value="{{ $book->id }}" id="book_id"
                                            hidden>

                                        <!-- Nội dung bình luận -->
                                        <div class="mb-3">
                                            <label for="comment" class="form-label fw-semibold">Nhận xét</label>
                                            <textarea name="comment" id="comment" rows="4" class="form-control"
                                                placeholder="Chia sẻ cảm nhận của bạn về sản phẩm..."></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa-solid fa-paper-plane me-2"></i>
                                            Gửi đánh giá
                                        </button>
                                    </form>
                                @else
                                    <div class="alert alert-warning mb-0">
                                        <i class="fa-solid fa-circle-exclamation me-2"></i>
                                        Vui lòng <a href="{{ route('login') }}" class="fw-bold">đăng nhập</a> để viết đánh
                                        giá.
                                    </div>
                                @endauth
                            </div>
                        </div>

                        <!-- Danh sách đánh giá -->
                        <div class="reviews-list">
                            <h5 class="fw-bold mb-4">Nhận xét từ khách hàng</h5>
                            <div class="card mb-3 border-0 shadow-sm">
                                <div class="card-body">
                                    @foreach ($reviews as $review)
                                        <div class="d-flex-row align-items-start mb-3" style="background: #ECECEC">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                                style="width: 48px; height: 48px; flex-shrink: 0;">
                                                <span class="fw-bold">GUEST</span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h6 class="mb-0 fw-semibold">{{ $review->user->name }}</h6>
                                                    <small class="text-muted">{{ $review->created_at }}</small>
                                                </div>
                                                <div class="text-warning mb-2">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $review->rating)
                                                            <i class="fa-solid fa-star"></i>
                                                        @else
                                                            <i class="fa-regular fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <p class="mb-0 text-muted">{{ $review->comment }}</p>
                                                <div class="mt-2">
                                                    <span class="badge bg-light text-dark me-2"><i
                                                            class="fa-solid fa-check text-success me-1"></i>Đã mua
                                                        hàng</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Nút xem thêm -->
                            {{-- <div class="text-center mt-4">
                                <button class="btn btn-outline-primary">
                                    Xem thêm đánh giá
                                    <i class="fa-solid fa-chevron-down ms-2"></i>
                                </button>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
