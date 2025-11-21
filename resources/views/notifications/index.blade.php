@extends('layouts.app')
@section('title', 'Thông báo')

@section('content')
<div class="container mt-4">
    <h2>Thông báo của bạn</h2>
    @foreach($notifications as $notif)
        <div class="card mb-2 {{ $notif->is_read ? '' : 'border-primary' }}">
            <div class="card-body">
                <h6 class="card-title">{{ $notif->title }}</h6>
                <p class="card-text">{{ $notif->message }}</p>
                <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
            </div>
        </div>
    @endforeach
    {{ $notifications->links() }}
</div>
@endsection