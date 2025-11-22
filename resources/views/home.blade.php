@extends('layouts.app')
@section('title', 'Home')

@section('content')
<style>
    /* Palette Colors */
    :root {
        --mulled-wine: #49110B;
        --woodland: #56483B;
        --antique-marble: #C8C2B7;
        --charcoal-smoke: #191A1E;
        --sandlight: #AD9E89;
        --goat-milk: #E7E5DB;
    }

    /* Hero Section */
    .hero-section h1 { color: var(--mulled-wine); }
    .hero-section p.lead { color: var(--woodland); }
    .hero-section .btn-primary { background-color: var(--mulled-wine); border-color: var(--mulled-wine); }
    .hero-section .btn-outline-secondary { color: var(--woodland); border-color: var(--woodland); }
    .hero-section .btn-outline-secondary:hover { background-color: var(--woodland); color: var(--goat-milk); }

    /* Cards for lawyers */
    .card-lawyer {
        background-color: var(--antique-marble);
        border: 1px solid var(--sandlight);
        border-radius: 12px;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .card-lawyer:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    .card-lawyer .card-title { color: var(--mulled-wine); font-weight: 600; }
    .card-lawyer .card-text { color: var(--woodland); }
    .card-lawyer img { border-top-left-radius: 12px; border-top-right-radius: 12px; }

    /* Book button */
    .btn-book {
        background-color: var(--sandlight);
        color: var(--charcoal-smoke);
        border: none;
    }
    .btn-book:hover {
        background-color: var(--mulled-wine);
        color: var(--goat-milk);
    }

    /* Announcements */
    .list-group-item {
        background-color: var(--goat-milk);
        border-left: 5px solid var(--mulled-wine);
        border-radius: 8px;
        margin-bottom: 10px;
        transition: background 0.3s;
    }
    .list-group-item:hover {
        background-color: var(--sandlight);
    }
    .list-group-item h5 { color: var(--mulled-wine); font-weight: 600; }
    .list-group-item p { color: var(--woodland); }

    /* Search Card */
    .card-search {
        background-color: var(--goat-milk);
        border: 1px solid var(--sandlight);
        border-radius: 12px;
    }
</style>

<div class="container py-5">

    {{-- Hero Section --}}
    <div class="row align-items-center mb-5 hero-section">
        <div class="col-md-6">
            <h1 class="display-4 fw-bold">Welcome to LegalEase ⚖️</h1>
            <p class="lead">Connect with verified lawyers quickly, securely, and conveniently.</p>
            <a href="{{ route('lawyers.index') }}" class="btn btn-primary btn-lg me-2">Find a Lawyer</a>
            @guest
                <a href="{{ route('register.choice') }}" class="btn btn-outline-secondary btn-lg">Register</a>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg">Sign In</a>
            @endguest
        </div>
        <div class="col-md-6 text-center">
            <img src="/images/home-hero.png" alt="LegalEase" class="img-fluid rounded">
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
                        <img src="{{ $lawyer->avatar ?? '/images/default-lawyer.jpg' }}" class="card-img-top" alt="{{ $lawyer->name }}">
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
                            <a href="{{ route('lawyers.show', $lawyer->id) }}" class="btn btn-book w-100">Book Appointment</a>
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
    <div class="list-group mb-5">
        @foreach($announcements as $announcement)
            <a href="{{ route('announcements.index') }}" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{ $announcement->title }}</h5>
                    <small>{{ $announcement->created_at->format('d/m/Y') }}</small>
                </div>
                <p class="mb-1 text-truncate">{{ $announcement->content }}</p>
            </a>
        @endforeach
    </div>

</div>
@endsection
