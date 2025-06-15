@php
    $payDateRaw = request('vnp_PayDate');
    $payDate = \Carbon\Carbon::createFromFormat('YmdHis', $payDateRaw)->format('H:i:s d/m/Y');
@endphp

@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center mb-3" style="min-height: 100vh; background: #d7f8d9;">
        <div class="card shadow" style="max-width: 500px; width: 100%; padding: 30px;">
            <div class="text-center mb-4">
                <i class="fas fa-check-circle" style="font-size: 60px; color: #09a32d;"></i>
                <h3 class="text-success mt-3">Thanh toán thành công</h3>
            </div>

            <div class="row mb-2">
                <div class="col-6 text-muted">Phương thức</div>
                <div class="col-6 text-end">VNPay</div>
            </div>
            <div class="row mb-2">
                <div class="col-6 text-muted">Ngân hàng</div>
                <div class="col-6 text-end">{{ request('vnp_BankCode') }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-6 text-muted">Mã giao dịch</div>
                <div class="col-6 text-end">{{ request('vnp_TransactionNo') }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-6 text-muted">Thời gian giao dịch</div>
                <div class="col-6 text-end">{{ $payDate }}</div>
            </div>
            <hr>
            <div class="row mb-2">
                <div class="col-6 text-muted fw-bold">Số tiền</div>
                <div class="col-6 text-end fw-bold">{{ number_format(request('vnp_Amount') / 100, 0, ',', '.') }} đ</div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button onclick="window.print()" class="btn btn-primary">In hóa đơn</button>
                <a href="{{ route('home') }}" class="btn btn-secondary">Về trang chủ</a>
            </div>
        </div>
    </div>
@endsection
