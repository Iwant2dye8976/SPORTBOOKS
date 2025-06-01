@extends('layouts.deliverer')

@section('title', 'Giao hàng')

@section('content')
    @if (Route::currentRouteName() === 'delivery.orders-m')
        @include('deliverer.orders-management')
    @endif
@endsection
