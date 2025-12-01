@extends('layouts.app')
@section('title', 'Notifications')

@section('content')
<style>
    body {
        background-color: #405649 !important;
    }

    .notif-container {
        max-width: 750px;
        margin: auto;
        color: #3A4B41 ;
    }

    h2 {
        color: #3A4B41 ;
        border-left: 6px solid #E6CFA7;
        padding-left: 10px;
        font-weight: 600;
        margin-bottom: 25px;
    }

    .notif-card {
        background-color: rgba(255, 255, 255, 0.07);
        border-radius: 10px;
        backdrop-filter: blur(3px);
        transition: 0.2s;
        border-left: 5px solid transparent;
    }

    .notif-card:hover {
        background-color: rgba(255, 255, 255, 0.12);
        transform: translateY(-2px);
    }

    /* Chưa đọc */
    .notif-unread {
        border-left: 5px solid #E6CFA7 !important;
        background-color: rgba(230, 207, 167, 0.18) !important;
    }

    .card-title {
        color: #3A4B41 ;
        font-weight: 600;
    }

    .card-text {
        color: #3A4B41 ;
    }

    .pagination .page-link {
        background-color: #E6CFA7;
        border: none;
        color: #3A4B41;
        font-weight: 600;
    }

    .pagination .page-item.active .page-link {
        background-color: #3A4B41;
        border: 1px solid #E6CFA7;
        color: #E6CFA7;
    }

    .pagination .page-link:hover {
        background-color: #d9c395;
        color: #3A4B41;
    }
</style>

<div class="container mt-4 notif-container">
    <h2>Your Notifications</h2>

    @foreach($notifications as $notif)
        <div class="card mb-3 notif-card {{ $notif->is_read ? '' : 'notif-unread' }}">
            <div class="card-body">
                <h6 class="card-title">{{ $notif->title }}</h6>
                <p class="card-text">{{ $notif->message }}</p>
                <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
            </div>
        </div>
    @endforeach

    <div class="mt-3">
        {{ $notifications->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
