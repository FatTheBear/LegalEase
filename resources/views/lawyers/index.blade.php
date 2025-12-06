@extends('layouts.app')
@section('title', 'Lawyers List')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Find and Book a Consultation with a Lawyer</h2>

    {{-- Search Form --}}
    <form method="GET" action="{{ route('lawyers.index') }}" class="row g-3 mb-4">
        <div class="col-md-5">
            <select name="specialization" class="form-select">
                <option value="">Select Specialization</option>
                @foreach($specializations as $spec)
                    <option value="{{ $spec }}" {{ request('specialization') == $spec ? 'selected' : '' }}>
                        {{ $spec }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-5">
            <select name="province" class="form-select">
                <option value="">Select Province/State</option>
                @foreach($provinces as $prov)
                    <option value="{{ $prov }}" {{ request('province') == $prov ? 'selected' : '' }}>
                        {{ $prov }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Search</button>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse($lawyers as $lawyer)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm hover-shadow border-0">
                    <div class="card-body d-flex flex-column">
                        <div class="text-center mb-3">
                            @php
                            $avatarUrl = $lawyer->hasAvatar()
                                ? $lawyer->getAvatarUrl()
                                : 'https://ui-avatars.com/api/?name=' . urlencode($lawyer->name) . '&background=35563c&color=ffffff&size=150';
                            @endphp

                            <img src="{{ $avatarUrl }}" 
                                class="rounded-circle shadow"
                                width="150" height="150"
                                alt="{{ $lawyer->name }}">

                        </div>

                        <h5 class="card-title text-center mb-2">
                            <a href="{{ route('lawyers.show', $lawyer->id) }}" class="text-decoration-none text-dark">
                                {{ $lawyer->name }}
                            </a>
                        </h5>

                        <div class="text-center text-muted small mb-3">
                            <i class="bi bi-briefcase"></i>
                            {{ $lawyer->lawyerProfile->specialization ?? 'General Practice' }}
                        </div>

                        <div class="row text-center small text-muted mb-3">
                            <div class="col-6">
                                <i class="bi bi-clock-history"></i>
                                {{ $lawyer->lawyerProfile->experience ?? 0 }} years experience
                            </div>
                            <div class="col-6">
                                <i class="bi bi-geo-alt"></i>
                                {{ $lawyer->lawyerProfile->province ?? 'Nationwide' }}
                            </div>
                        </div>

                        <div class="text-center mb-3">
                            @php
                                $avgRating = $lawyer->ratings->avg('rating');
                            @endphp
                            @if($avgRating)
                                <span class="text-warning">
                                    {{ str_repeat('★', floor($avgRating)) }}
                                    {{ str_repeat('☆', 5 - floor($avgRating)) }}
                                    <strong>{{ number_format($avgRating, 1) }}</strong>
                                </span>
                            @else
                                <span class="text-muted">No ratings yet</span>
                            @endif
                        </div>

                        <div class="mt-auto text-center">
                            <a href="{{ route('lawyers.show', $lawyer->id) }}"
                               class="btn btn-primary w-100">
                               <i class="bi bi-calendar-check"></i> Book Consultation
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-emoji-frown" style="font-size: 4rem; color: #ccc;"></i>
                    <p class="text-muted mt-3">No lawyers available at the moment. Please check back later!</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4 ">
        {{ $lawyers->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection

{{-- Small CSS for hover effect --}}
@section('styles')
<style>
    .hover-shadow {
        transition: all 0.3s ease;
    }
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection
