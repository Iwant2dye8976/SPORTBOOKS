@extends('layouts.admin')

@section('title', 'Quản trị viên')

@section('content')
    @if (Route::currentRouteName() === 'admin.book-m')
        @include('admin.book-management')
    @endif
    @if (Route::currentRouteName() === 'admin.user-m')
        @include('admin.user-management')
    @endif
@endsection
