@php
    $payDateRaw = request('vnp_PayDate');
    $payDate = null;

    try {
        if ($payDateRaw) {
            $payDate = \Carbon\Carbon::createFromFormat('YmdHis', $payDateRaw)->format('H:i:s d/m/Y');
        }
    } catch (\Exception $e) {
        $payDate = null;
    }
@endphp

@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center mb-3" style="min-height: 100vh; background: #f8d7da;">
        <div class="card shadow" style="max-width: 500px; width: 100%; padding: 30px;">
            <div class="text-center mb-4">
                <i class="fas fa-times-circle" style="font-size: 60px; color: #dc3545;"></i>
                <h3 class="text-danger mt-3">Thanh toán thất bại</h3>
                <p class="text-muted mt-2">{{ $message ?? 'Đã xảy ra lỗi trong quá trình thanh toán.' }}</p>
            </div>

            <div class="row mb-2">
                <div class="col-6 text-muted">Phương thức</div>
                <div class="col-6 text-end">VNPay</div>
            </div>
            @if(request('vnp_BankCode'))
                <div class="row mb-2">
                    <div class="col-6 text-muted">Ngân hàng</div>
                    <div class="col-6 text-end">{{ request('vnp_BankCode') }}</div>
                </div>
            @endif
            @if(request('vnp_TransactionNo'))
                <div class="row mb-2">
                    <div class="col-6 text-muted">Mã giao dịch</div>
                    <div class="col-6 text-end">{{ request('vnp_TransactionNo') }}</div>
                </div>
            @endif
            @if($payDate)
                <div class="row mb-2">
                    <div class="col-6 text-muted">Thời gian giao dịch</div>
                    <div class="col-6 text-end">{{ $payDate }}</div>
                </div>
            @endif

            @if(request('vnp_Amount'))
                <hr>
                <div class="row mb-2">
                    <div class="col-6 text-muted fw-bold">Số tiền</div>
                    <div class="col-6 text-end fw-bold">{{ number_format(request('vnp_Amount') / 100, 0, ',', '.') }} đ</div>
                </div>
            @endif

            <div class="d-flex justify-content-center mt-4">
                <a href="{{ route('home') }}" class="btn btn-secondary">Về trang chủ</a>
            </div>
        </div>
    </div>
@endsection
