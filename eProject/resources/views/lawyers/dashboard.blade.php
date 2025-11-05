@extends('layouts.app')
@section('title', 'Dashboard Luật sư')

@section('content')
<h2>Xin chào, {{ Auth::user()->name }}</h2>
<p>Thống kê công việc hôm nay:</p>
<ul>
    <li>Lịch hẹn đang chờ: {{ $pending }}</li>
    <li>Lịch hẹn hoàn thành: {{ $completed }}</li>
    <li>Đánh giá trung bình: {{ $rating }}</li>
</ul>
<a href="{{ route('appointments.index') }}" class="btn btn-primary">Xem lịch hẹn</a>
@endsection
