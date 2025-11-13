@extends('layouts.app')
@section('title', 'Thông báo')

@section('content')
<h2>Thông báo mới nhất</h2>
@foreach($announcements as $a)
<div class="card mb-3">
    <div class="card-body">
        <h5>{{ $a->title }}</h5>
        <p>{{ $a->content }}</p>
        <small>Ngày đăng: {{ $a->publish_date }}</small>
    </div>
</div>
@endforeach
@endsection
