@extends('layouts.app')
@section('title', 'Dashboard Khách hàng')

@section('content')
<h2>Xin chào, {{ Auth::user()->name }}</h2>
<p>Quản lý các lịch hẹn của bạn tại đây:</p>
<a href="{{ route('appointments.index') }}" class="btn btn-primary">Xem lịch hẹn</a>
<a href="{{ route('lawyers.index') }}" class="btn btn-success">Tìm luật sư</a>
@endsection
