@extends('layouts.app')
@section('title', 'Thông báo')

@section('content')
<h2 class="mb-4 text-center">Latest Announcement</h2>
@foreach($announcements as $a)
<div class="card mb-3">
    <div class="card-body">
        <h5>{{ $a->title }}</h5>
        <p>{{ $a->content }}</p>
        <small>Date of Publication: {{ $a->publish_date }}</small>
    </div>
</div>
@endforeach
@endsection
