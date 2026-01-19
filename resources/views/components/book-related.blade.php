<div>
    <h5 class="mb-4">Sách liên quan</h5>
</div>
<div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4" style="background-color: #fbe3e8;">
    @foreach ($relatedBooks as $rbook)
        <div class="col">
            <div class="card h-100 border-0 shadow-sm hover-lift transition-all">
                <div class="position-relative overflow-hidden" style="background-color: #f8f9fa;">
                    <a href="{{ route('detail', $rbook->id) }}" class="d-block">
                        <img src="{{ $rbook->image_url }}" class="card-img-top p-3" alt="{{ $rbook->title }}"
                            title="{{ $rbook->title }}"
                            style="height: 280px; object-fit: contain; transition: transform 0.3s ease;"
                            onmouseover="this.style.transform='scale(1.05)'"
                            onmouseout="this.style.transform='scale(1)'">
                    </a>

                    <!-- Badge giảm giá (nếu có) -->
                    @if (isset($rbook->discount) && $rbook->discount > 0)
                        <span class="position-absolute top-0 end-0 badge bg-danger m-2">
                            -{{ $rbook->discount }}%
                        </span>
                    @endif
                </div>

                <div class="card-body d-flex flex-column">
                    <h6 class="card-title mb-2"
                        style="height: 40px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"
                        title="{{ $rbook->title }}">
                        <a class="text-decoration-none text-dark hover-primary"
                            href="{{ route('detail', $rbook->id) }}">
                            {{ $rbook->title }}
                        </a>
                    </h6>

                    @if (isset($rbook->author))
                        <p class="text-muted small mb-2">
                            <i class="fa-solid fa-user-pen me-1"></i>
                            {{ $rbook->author }}
                        </p>
                    @endif

                    <div class="mt-auto">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                @if (isset($rbook->origin_price))
                                    @if (isset($rbook->discount) && $rbook->discount > 0)
                                        <p class="text-danger fw-bold fs-5 mb-0">
                                            {{ number_format(ceil($rbook->final_price * 25000), 0, ',', '.') }}đ
                                        </p>
                                        <p class="text-muted text-decoration-line-through small mb-0">
                                            {{ number_format($rbook->origin_price * 25000, 0, ',', '.') }}đ
                                        </p>
                                    @else
                                        <p class="text-danger fw-bold fs-5 mb-0">
                                            {{ number_format($rbook->final_price * 25000, 0, ',', '.') }}đ
                                        </p>
                                    @endif
                                @endif
                            </div>

                            <form action="{{ route('cart.add', $rbook->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-outline-primary btn-sm rounded-circle"
                                    style="width: 36px; height: 36px;" title="Thêm vào giỏ hàng" type="submit">
                                    <i class="fa-solid fa-cart-plus"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
