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
                <option value="Criminal Law" {{ request('specialization') == 'Criminal Law' ? 'selected' : '' }}>Criminal Law</option>
                <option value="Corporate Law" {{ request('specialization') == 'Corporate Law' ? 'selected' : '' }}>Corporate Law</option>
                <option value="Family Law" {{ request('specialization') == 'Family Law' ? 'selected' : '' }}>Family Law</option>
                <option value="Intellectual Property" {{ request('specialization') == 'Intellectual Property' ? 'selected' : '' }}>Intellectual Property</option>
                <option value="Immigration Law" {{ request('specialization') == 'Immigration Law' ? 'selected' : '' }}>Immigration Law</option>
                <option value="Tax Law" {{ request('specialization') == 'Tax Law' ? 'selected' : '' }}>Tax Law</option>
                <option value="Real Estate Law" {{ request('specialization') == 'Real Estate Law' ? 'selected' : '' }}>Real Estate Law</option>
                <option value="Employment Law" {{ request('specialization') == 'Employment Law' ? 'selected' : '' }}>Employment Law</option>
                <option value="Civil Litigation" {{ request('specialization') == 'Civil Litigation' ? 'selected' : '' }}>Civil Litigation</option>
                <option value="Contract Law" {{ request('specialization') == 'Contract Law' ? 'selected' : '' }}>Contract Law</option>
            </select>
        </div>

        <div class="col-md-5">
            <select name="province" class="form-select">
                <option value="">Select Province/State</option>
                <option value="New York" {{ request('province') == 'New York' ? 'selected' : '' }}>New York</option>
                <option value="California" {{ request('province') == 'California' ? 'selected' : '' }}>California</option>
                <option value="Florida" {{ request('province') == 'Florida' ? 'selected' : '' }}>Florida</option>
                <option value="Texas" {{ request('province') == 'Texas' ? 'selected' : '' }}>Texas</option>
                <option value="Illinois" {{ request('province') == 'Illinois' ? 'selected' : '' }}>Illinois</option>
                <option value="Massachusetts" {{ request('province') == 'Massachusetts' ? 'selected' : '' }}>Massachusetts</option>
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
                            <img src="{{ $lawyer->avatar ?? asset('images/default-lawyer.jpg') }}"
                                 class="rounded-circle" width="100" height="100" alt="{{ $lawyer->name }}">
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

    <!-- Pagination -->
    <div class="mt-4">
        {{ $lawyers->appends(request()->query())->links() }}
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
