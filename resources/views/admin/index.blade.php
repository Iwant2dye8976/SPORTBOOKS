@extends('layouts.admin')

@section('title', 'Quản trị viên')

@section('content')
    @if (Route::currentRouteName() === 'admin.book-m' || Route::currentRouteName() === 'admin.book-m.search')
        @include('admin.books-management')
    @endif

    @if (Route::currentRouteName() === 'admin.book-m.add')
        @include('admin.books-managetment-add')
    @endif

    @if (Route::currentRouteName() === 'admin.book-m.detail')
        @include('admin.books-management-detail')
    @endif

    @if (Route::currentRouteName() === 'admin.user-m' || Route::currentRouteName() === 'admin.user-m.search')
        @include('admin.users-management')
    @endif

    @if (Route::currentRouteName() === 'admin.order-m')
        @include('admin.orders-management')
    @endif
    @if (Route::currentRouteName() === 'admin.order-m.detail')
        @include('admin.order-management-detail')
    @endif
    @if (Route::currentRouteName() === 'admin.user-m.detail')
        @include('admin.users-management-detail')
    @endif
    
@endsection
