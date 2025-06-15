@extends('layouts.deliverer')

@section('title', 'Giao hàng')

@section('content')
    @if (Route::currentRouteName() === 'delivery.orders-m' || Route::currentRouteName() === 'delivery.orders-cl' || Route::currentRouteName() === 'delivery.orders-m.search')
        @include('deliverer.orders-management')
    @endif
    @if (Route::currentRouteName() === 'delivery.orders-d')
        @include('deliverer.order-management-detail')
    @endif
    @if (Route::currentRouteName() === 'delivery.my-orders')
        @include('deliverer.my-orders')
    @endif
    @if (Route::currentRouteName() === 'delivery.my-orders-detail')
        @include('deliverer.order-management-detail')
    @endif
@endsection
