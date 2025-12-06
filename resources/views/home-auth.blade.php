@extends('layouts.app')

@section('title', 'Home')

@section('content')
<style>
    :root {
        --primary: #3a4b41;
        --secondary: #E6CFA7;
    }
    
    /* Beige card styling for lawyers */
    .card-lawyer {
        background-color: #E6CFA7 !important;
        border: none !important;
    }
    
    .card-lawyer .card-body {
        background-color: #E6CFA7;
        color: #333;
    }
    
    .card-lawyer .card-title {
        font-weight: 600;
        color: #2d2d2d;
    }
    
    .card-lawyer .card-text {
        color: #555;
    }
    
    .card-lawyer .text-muted {
        color: #666 !important;
    }
    
    .card-lawyer .btn-book {
        background-color: #3a4b41 !important;
        border-color: #3a4b41 !important;
        color: white !important;
        font-weight: 500;
    }
    
    .card-lawyer .btn-book:hover {
        background-color: #2d3d33 !important;
        border-color: #2d3d33 !important;
    }
    
    /* Search card styling */
    .card-search {
        background-color: #E6CFA7 !important;
        border: none !important;
    }
    
    .card-search .form-select {
        border: 1px solid #999;
        background-color: white;
    }
    
    .card-search .btn {
        background-color: #3a4b41 !important;
        border-color: #3a4b41 !important;
        color: #E6CFA7 !important;
        font-weight: 500;
    }
    
    .card-search .btn:hover {
        background-color: #2d3d33 !important;
    }
    
    /* Hero Find Lawyer button */
    .hero-section .btn-primary {
        background-color: #3a4b41 !important;
        border-color: #3a4b41 !important;
        color: #E6CFA7 !important;
    }
    
    .hero-section .btn-primary:hover {
        background-color: #2d3d33 !important;
        border-color: #2d3d33 !important;
    }
</style>

{{-- Hero Section --}}
<div class="row align-items-center mb-5 hero-section">
    <div class="col-md-6">
        <h1 class="display-4 fw-bold">Welcome to LegalEase</h1>
        
        <p class="lead">Connect with verified lawyers quickly, securely, and conveniently.</p>
        
        <a href="{{ route('lawyers.index') }}" class="btn btn-primary btn-lg me-2">Find a Lawyer</a>
    </div>
    <div class="col-md-6 text-center">
        <img src="/images/logohome1.png" alt="LegalEase" class="img-fluid rounded">
    </div>
</div>

{{-- Lawyer Search --}}
<div class="card shadow mb-5 p-4 card-search">
    <form action="{{ route('home') }}" method="GET" class="row g-3 align-items-center">
        <div class="col-md-5">
            <select name="specialization" class="form-select">
                <option value="">Select Specialization</option>
                @foreach($specializations as $spec)
                    <option value="{{ $spec }}" {{ $spec == $specialization ? 'selected' : '' }}>{{ $spec }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-5">
            <select name="province" class="form-select">
                <option value="">Select Province</option>
                @foreach($provinces as $prov)
                    <option value="{{ $prov }}" {{ $prov == $province ? 'selected' : '' }}>{{ $prov }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-grid">
            <button class="btn btn-primary">Search</button>
        </div>
    </form>
</div>

{{-- Search Results / Featured Lawyers --}}
@php $lawyersToShow = $searchResults ?? $featuredLawyers; @endphp
@if($lawyersToShow)
    <h2 class="mb-4">{{ $searchResults ? 'Search Results' : 'Featured Lawyers' }}</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
        @forelse($lawyersToShow as $lawyer)
            <div class="col">
                <div class="card h-100 shadow-sm card-lawyer">
                    <img src="{{ $lawyer->hasAvatar() ? $lawyer->getAvatarUrl() : '/images/default-lawyer.jpg' }}" class="card-img-top" alt="{{ $lawyer->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $lawyer->name }}</h5>
                        <p class="card-text">{{ $lawyer->lawyerProfile->specialization ?? 'General Lawyer' }}</p>
                        <p class="text-muted"><i class="bi bi-geo-alt"></i> {{ $lawyer->lawyerProfile->province ?? 'Nationwide' }}</p>
                        <p>
                            @php $avgRating = $lawyer->ratings->avg('rating'); @endphp
                            @if($avgRating)
                                <i class="bi bi-star-fill text-warning"></i>
                                {{ number_format($avgRating, 1) }}
                            @else
                                <span class="text-muted">No Ratings Yet</span>
                            @endif
                        </p>
                        <a href="{{ route('lawyers.show', $lawyer->id) }}" class="btn btn-book w-100 btn-primary">Book Appointment</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-emoji-frown" style="font-size: 4rem; color: #ccc;"></i>
                <p class="text-muted mt-3">No lawyers found matching your criteria.</p>
            </div>
        @endforelse
    </div>
@endif

{{-- Announcements --}}
<h2 class="mb-4">Legal Updates & Announcements</h2>
<div class="list-group mb-5 ">
    @foreach($announcements as $announcement)
        <a href="{{ route('announcements.index') }}" class="list-group-item list-group-item-action btn-primary"
                   style="
                        background-color: #3A4B41; 
                        color: #FFD700; 
                        padding: 20px; 
                        border-radius: 12px; 
                        margin-bottom: 12px; 
                        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                        transition: 0.25s;
                    ">
            <div class="d-flex w-100 justify-content-between btn-primary">
                <h5 class="mb-1">{{ $announcement->title }}</h5>
                <small>{{ $announcement->created_at->format('d/m/Y') }}</small>
            </div>
            <p class="mb-1 text-truncate">{{ $announcement->content }}</p>
        </a>
        <br>
    @endforeach
</div>

@endsection
