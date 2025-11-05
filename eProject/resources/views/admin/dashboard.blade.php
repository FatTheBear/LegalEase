@extends('layouts.app')
@section('title', 'Dashboard Quản trị')

@section('content')
<h2>Bảng điều khiển Quản trị</h2>
<ul>
    <li><a href="{{ route('admin.users') }}">Quản lý người dùng</a></li>
    <li><a href="{{ route('admin.lawyers') }}">Quản lý luật sư</a></li>
    <li><a href="{{ route('admin.appointments') }}">Lịch hẹn</a></li>
</ul>
@endsection
