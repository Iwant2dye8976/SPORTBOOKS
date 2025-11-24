@php
    $status = $order_information->status;
    $done = $status >= -1 && $status !== 0;
    $color = $status === 0 ? 'danger' : ($done ? 'success' : 'secondary');
@endphp

<div class="{{ $status === 0 ? '' : 'd-flex justify-content-center align-items-start text-center' }}"
    style="display: none;">
    {{-- STEP 1: Đặt hàng --}}
    <div class="me-3">

        <div style="width: 70px; height: 70px;"
            class="border border-{{ $color }} border-2 rounded-circle d-flex justify-content-center align-items-center bg-{{ $done ? $color : 'white' }} text-{{ $done ? 'white' : $color }} mx-auto">
            <i class="fa-solid fa-basket-shopping fs-3"></i>
        </div>
        <div class="mt-2 fw-bold text-{{ $color }}">
            {{ $status === 0 ? 'Đơn hàng bị hủy' : 'Đặt hàng thành công' }}
        </div>
    </div>

    {{-- LINE 1 --}}
    <div class="align-self-center mx-2"
        style="width: 70px; height: 3px; background-color: {{ $status >= 1 ? '#198754' : '#adb5bd' }};"></div>

    {{-- STEP 2: Thanh toán --}}
    <div class="me-3">
        @php
            $done = $status >= 2;
            $active = $status === 1;
            $c = $status === 0 ? 'danger' : ($active ? 'warning' : ($done ? 'success' : 'secondary'));
        @endphp
        <div style="width: 70px; height: 70px;"
            class="border border-{{ $c }} border-2 rounded-circle d-flex justify-content-center align-items-center bg-{{ $active || $done ? $c : 'white' }} text-{{ $active || $done ? 'white' : $c }} mx-auto">
            <i class="fa-solid fa-wallet fs-3"></i>
        </div>
        <div class="mt-2 fw-bold text-{{ $c }}">
            @switch($status)
                @case(1)
                    Chờ thanh toán
                @break

                @case(0)
                @break

                @default
                    {{ $status >= 2 ? 'Đã thanh toán' : 'Chưa thanh toán' }}
            @endswitch
        </div>
    </div>

    {{-- LINE 2 --}}
    <div class="align-self-center mx-2"
        style="width: 70px; height: 3px; background-color: {{ $status >= 3 ? '#198754' : '#adb5bd' }};"></div>

    {{-- STEP 3: Giao hàng --}}
    <div class="me-3">
        @php
            $done = $status >= 3;
            $active = $status === 2 || $status === 3;
            $c = $status === 0 ? 'danger' : ($active ? 'primary' : ($done ? 'success' : 'secondary'));
        @endphp
        <div style="width: 70px; height: 70px;"
            class="border border-{{ $c }} border-2 rounded-circle d-flex justify-content-center align-items-center bg-{{ $active || $done ? $c : 'white' }} text-{{ $active || $done ? 'white' : $c }} mx-auto">
            <i class="fa-solid fa-truck-fast fs-3"></i>
        </div>
        <div class="mt-2 fw-bold text-{{ $c }}">
            @switch($status)
                @case(2)
                    Chờ giao hàng
                @break

                @case(0)
                @break

                @case(3)
                    Đang giao hàng
                @break

                @default
                    {{ $status >= 4 ? 'Đã giao xong' : 'Chưa giao' }}
            @endswitch
        </div>
    </div>

    {{-- LINE 3 --}}
    <div class="align-self-center mx-2"
        style="width: 70px; height: 3px; background-color: {{ $status >= 4 ? '#198754' : '#adb5bd' }};"></div>

    {{-- STEP 4: Nhận hàng --}}
    <div class="me-3">
        @php
            $done = $status === 4;
            $c = $status === 0 ? 'danger' : ($done ? 'success' : 'secondary');
        @endphp
        <div style="width: 70px; height: 70px;"
            class="border border-{{ $c }} border-2 rounded-circle d-flex justify-content-center align-items-center bg-{{ $done ? $c : 'white' }} text-{{ $done ? 'white' : $c }} mx-auto">
            <i class="fa-solid fa-circle-check fs-3"></i>
        </div>
        <div class="mt-2 fw-bold text-{{ $c }}">
            @switch($status)
                @case(4)
                    Đã nhận hàng
                @break

                @case(0)
                @break

                @default
                    Chưa nhận hàng
            @endswitch
        </div>
    </div>
</div>
