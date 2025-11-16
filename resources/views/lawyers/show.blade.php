@extends('layouts.app')
@section('title', 'Chi tiết Luật sư')

@section('content')
<h2>{{ $lawyer->user->name }}</h2>
<p><strong>Chuyên ngành:</strong> {{ $lawyer->specialization }}</p>
<p><strong>Kinh nghiệm:</strong> {{ $lawyer->experience }} năm</p>
<p><strong>Tỉnh/Thành:</strong> {{ $lawyer->province }}</p>
<p><strong>Đánh giá:</strong> {{ $lawyer->rating }}</p>
<p><strong>Giới thiệu:</strong> {{ $lawyer->bio }}</p>
<a href="{{ route('appointments.create') }}" class="btn btn-success">Đặt lịch tư vấn</a>
@endsection
