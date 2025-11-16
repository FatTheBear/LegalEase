@extends('layouts.app')
@section('title', 'Trang chủ')

@section('content')
<div class="text-center">
    <h1>Chào mừng đến với LegalEase ⚖️</h1>
    <p class="lead">Nền tảng kết nối khách hàng và luật sư một cách nhanh chóng, tiện lợi và bảo mật.</p>
    <a href="{{ route('lawyers.index') }}" class="btn btn-primary">Tìm Luật Sư Ngay</a>
</div>
@endsection
