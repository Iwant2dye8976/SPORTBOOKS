@section('title', 'Chi tiết đơn hàng')

@section('content')
    <div class="mb-4">
        <a class="text-decoration-none text-dark fs-5" href="{{ url('admin/odrermanagement') }}">
            <i class="fas fa-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    <div class="container my-4">
        {{-- Alerts --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="fa-solid fa-receipt me-2 text-primary"></i>
                Đơn hàng #{{ $order_information->id }}
            </h2>
            <div>
                <span class="badge bg-primary rounded-pill fs-6">
                    {{ number_format(ceil($order_information->total * 25000), 0, ',', '.') }}đ
                </span>
                <small class="text-muted ms-2">({{ $order_details->count() }} sản phẩm)</small>
            </div>
        </div>

        <div class="row g-4">
            {{-- Cột trái: Danh sách sản phẩm --}}
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-semibold">Danh sách sản phẩm</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 100px;">Ảnh</th>
                                        <th>Sản phẩm</th>
                                        <th class="text-center">Số lượng</th>
                                        <th class="text-center">Đơn giá</th>
                                        <th class="text-center">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order_details as $item)
                                        <tr>
                                            <td>
                                                <img src="{{ $item->book->image_url }}" alt="{{ $item->book->title }}"
                                                    class="img-fluid rounded"
                                                    style="width:70px;height:90px;object-fit:cover;">
                                            </td>
                                            <td>
                                                <h6 class="mb-1 fw-semibold">{{ $item->book->title }}</h6>
                                                @if ($item->book->author)
                                                    <small class="text-muted">
                                                        <i class="fa-solid fa-user-pen me-1"></i>{{ $item->book->author }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td class="text-center fw-semibold">{{ $item->book_quantity }}</td>
                                            <td class="text-center">
                                                {{ number_format(ceil($item->book->price * 25000), 0, ',', '.') }}đ
                                            </td>
                                            <td class="text-center fw-bold">
                                                {{ number_format(ceil($item->book_quantity * $item->book->price * 25000), 0, ',', '.') }}đ
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Trạng thái đơn hàng --}}
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body">
                        <h5 class="fw-semibold">Trạng thái đơn hàng</h5>
                        <p class="mb-2">
                            @switch($order_information->status)
                                @case(-1)
                                    <span class="text-warning fw-bold">Chờ xử lý</span>
                                @break

                                @case(0)
                                    <span class="text-danger fw-bold">Đã hủy</span>
                                @break

                                @case(1)
                                    <span class="text-warning fw-bold">Chờ thanh toán</span>
                                @break

                                @case(2)
                                    <span class="text-warning fw-bold">Chờ giao hàng</span>
                                @break

                                @case(3)
                                    <span class="text-warning fw-bold">Đang giao hàng</span>
                                @break

                                @case(4)
                                    <span class="text-success fw-bold">Đã nhận hàng</span>
                                @break

                                @default
                                    <span class="text-primary fw-bold">Không xác định</span>
                            @endswitch
                        </p>
                    </div>
                </div>
            </div>

            {{-- Cột phải: Thông tin giao hàng và thanh toán --}}
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-semibold">Thông tin giao hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small">Họ và tên</label>
                            <input class="form-control-plaintext fw-bold" readonly
                                value="{{ $order_information->recipient_name }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Địa chỉ</label>
                            <div class="form-control-plaintext text-break">{{ $order_information->shipping_address }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Số điện thoại</label>
                            <div class="form-control-plaintext">{{ $order_information->phone_number }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Ghi chú</label>
                            <div class="form-control-plaintext text-muted">{{ $order_information->note ?? '-' }}</div>
                        </div>

                        <hr>
                        <h6 class="fw-semibold">Chi tiết thanh toán</h6>
                        <div class="d-flex justify-content-between">
                            <div>Tiền sách</div>
                            <div>{{ number_format($order_information->books_price * 25000, 0, ',', '.') }}đ</div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>Phí vận chuyển</div>
                            <div>{{ number_format($order_information->shipping_fee * 25000, 0, ',', '.') }}đ</div>
                        </div>
                        <div class="d-flex justify-content-between fw-bold mt-2">
                            <div>Tổng</div>
                            <div>{{ number_format($order_information->total * 25000, 0, ',', '.') }}đ</div>
                        </div>
                    </div>
                </div>

                {{-- Nút xác nhận / hủy --}}
                @if ($order_information->status == -1)
                    <div class="mt-3">
                        <div class="row g-2">
                            <div class="col">
                                <form method="POST" action="{{ route('admin.order-cancel', $order_information->id) }}"
                                    onsubmit="disableButon()">
                                    @csrf
                                    <input type="number" value="{{ $order_information->id }}" name="order_id" hidden>
                                    <a class="form-control btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#cancel-modal">HỦY
                                        ĐƠN HÀNG</a>
                                    <div class="modal fade" id="cancel-modal" tabindex="-1" aria-labelledby="deleteModal"
                                        aria-hidden="true" data-bs-backdrop="static">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">HỦY ĐƠN HÀNG</h5> <button type="button"
                                                        class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-break"> Bạn có chắc muốn <strong
                                                        class="text text-danger">hủy đơn hàng này?</strong> </div>
                                                <div class="modal-footer"> <button type="submit"
                                                        class="btn btn-danger">XÁC
                                                        NHẬN</button> <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">HỦY</button> </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col">
                                <form method="POST" action="{{ route('admin.order-confirm', $order_information->id) }}" onsubmit="disableButon()">
                                    @csrf
                                    <input type="number" value="{{ $order_information->id }}" name="order_id" hidden>
                                    <a class="form-control btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#confirm-modal">XÁC NHẬN ĐƠN HÀNG</a>
                                    <div class="modal fade" id="confirm-modal" tabindex="-1"
                                        aria-labelledby="deleteModal" aria-hidden="true" data-bs-backdrop="static">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">XÁC NHẬN ĐƠN HÀNG</h5> <button type="button"
                                                        class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-break"> Bạn có chắc muốn <strong
                                                        class="text text-danger">xác nhận đơn hàng này?</strong> </div>
                                                <div class="modal-footer"> <button type="submit"
                                                        class="btn btn-primary">XÁC
                                                        NHẬN</button> <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">HỦY</button> </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
