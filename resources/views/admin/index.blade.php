@extends('layouts.admin')

@section('title', 'Quản trị viên')

@section('content')
    @if (Route::currentRouteName() === 'admin.index')
        <div class="row row-cols-1">
            <h2 class="text text-secondary text-center">Hãy chọn một thao tác quản lý</h2>
        </div>
    @endif

    @if (Route::currentRouteName() === 'admin.book-m')
        @include('admin.books-management')
    @endif

    @if (Route::currentRouteName() === 'admin.book-m.add')
        @include('admin.books-managetment-add')
    @endif

    @if (Route::currentRouteName() === 'admin.book-m.detail')
        @include('admin.books-management-detail')
    @endif

    @if (Route::currentRouteName() === 'admin.user-m')
        @include('admin.users-management')
    @endif

    @if (Route::currentRouteName() === 'admin.order-m')
        @include('admin.orders-management')
    @endif
    @if (Route::currentRouteName() === 'admin.order-m.detail')
        @include('admin.order-management-detail')
    @endif
    
@endsection
