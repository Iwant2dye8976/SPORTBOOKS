<div class="col">
    <div class="card h-100 border-0 shadow-sm hover-lift transition-all">
        <div class="position-relative overflow-hidden" style="background-color: #f8f9fa;">
            <a href="{{ route('detail', $book->id) }}" class="d-block">
                <img src="{{ $book->image_url }}" class="card-img-top p-3" alt="{{ $book->title }}"
                    title="{{ $book->title }}"
                    style="height: 280px; object-fit: contain; transition: transform 0.3s ease;"
                    onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            </a>

            <!-- Badge giảm giá (nếu có) -->
            @if (isset($book->discount) && $book->discount > 0)
                <span class="position-absolute top-0 end-0 badge bg-danger m-2">
                    -{{ $book->discount }}%
                </span>
            @endif
        </div>

        <div class="card-body d-flex flex-column">
            <h6 class="card-title mb-2"
                style="height: 40px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"
                title="{{ $book->title }}">
                <a class="text-decoration-none text-dark hover-primary" href="{{ route('detail', $book->id) }}">
                    {{ $book->title }}
                </a>
            </h6>

            @if (isset($book->author))
                <p class="text-muted small mb-2">
                    <i class="fa-solid fa-user-pen me-1"></i>
                    {{ $book->author }}
                </p>
            @endif

            @if (isset($book->bookreviews))
                <p class="text-muted small mb-2">
                    <i class="fa-solid fa-star text-warning me-1"></i>
                    {{ number_format($book->bookreviews->avg('rating'), 1) }} / 5.0
                </p>
            @endif

            <div class="mt-auto">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        @if (isset($book->origin_price))
                            @if (isset($book->discount) && $book->discount > 0)
                                <p class="text-danger fw-bold fs-5 mb-0">
                                    {{ number_format(ceil($book->final_price * 25000), 0, ',', '.') }}đ
                                </p>
                                <p class="text-muted text-decoration-line-through small mb-0">
                                    {{ number_format($book->origin_price * 25000, 0, ',', '.') }}đ
                                </p>
                            @else
                                <p class="text-danger fw-bold fs-5 mb-0">
                                    {{ number_format($book->final_price * 25000, 0, ',', '.') }}đ
                                </p>
                            @endif
                        @endif
                    </div>

                    <form action="{{ route('cart.add', $book->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-primary btn-sm rounded-circle" style="width: 36px; height: 36px;"
                            title="Thêm vào giỏ hàng" type="submit">
                            <i class="fa-solid fa-cart-plus"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
