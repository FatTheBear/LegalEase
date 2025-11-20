@extends('layouts.app')
@section('title', 'Lawyer Profile - ' . $lawyer->name)

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Lawyer Profile Section -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Lawyer Header -->
                    <div class="d-flex align-items-center mb-4">
                        @if($lawyer->lawyerProfile->avatar ?? false)
                            <img src="{{ asset('storage/' . $lawyer->lawyerProfile->avatar) }}" alt="{{ $lawyer->name }}" class="rounded-circle me-4" style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-secondary me-4 d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                <i class="bi bi-person-fill text-white" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        <div>
                            <h2 class="mb-2">{{ $lawyer->name }}</h2>
                            <p class="text-muted mb-1">
                                <i class="bi bi-briefcase"></i>
                                <strong>Specialization:</strong> {{ $lawyer->lawyerProfile->specialization ?? 'N/A' }}
                            </p>
                            <p class="text-muted mb-1">
                                <i class="bi bi-geo-alt"></i>
                                <strong>Location:</strong> {{ $lawyer->lawyerProfile->city ?? 'N/A' }}, {{ $lawyer->lawyerProfile->province ?? 'N/A' }}
                            </p>
                            <p class="text-warning">
                                <i class="bi bi-star-fill"></i>
                                <strong>Rating:</strong> {{ $lawyer->lawyerProfile->rating ?? '0' }}/5.0
                            </p>
                        </div>
                    </div>

                    <hr>

                    <!-- Experience & License -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>Years of Experience:</strong></p>
                            <p class="text-primary">{{ $lawyer->lawyerProfile->experience ?? '0' }} years</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>License Number:</strong></p>
                            <p class="text-primary">{{ $lawyer->lawyerProfile->license_number ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <hr>

                    <!-- Bio -->
                    <div class="mb-4">
                        <h5 class="mb-3">Professional Bio</h5>
                        <p>{{ $lawyer->lawyerProfile->bio ?? 'No bio available' }}</p>
                    </div>

                    <hr>

                    <!-- Approval Status -->
                    <div class="alert alert-info d-flex align-items-center">
                        <i class="bi bi-check-circle me-2"></i>
                        <span><strong>Status:</strong> {{ ucfirst($lawyer->lawyerProfile->approval_status ?? 'pending') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Section -->
        <div class="col-md-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-body">
                    <h5 class="card-title mb-4">Book an Appointment</h5>

                    @auth
                        @if(auth()->user()->role === 'customer')
                            <form action="{{ route('appointments.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="lawyer_id" value="{{ $lawyer->id }}">

                                <div class="mb-3">
                                    <label for="date" class="form-label">Preferred Date</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                           id="date" name="date" required min="{{ date('Y-m-d') }}">
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="time" class="form-label">Preferred Time</label>
                                    <input type="time" class="form-control @error('time') is-invalid @enderror" 
                                           id="time" name="time" required>
                                    @error('time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes (Optional)</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" name="notes" rows="4" placeholder="Describe your legal matter..."></textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-calendar-check"></i> Book Appointment
                                </button>
                            </form>
                        @else
                            <div class="alert alert-warning">
                                <i class="bi bi-info-circle"></i>
                                Only customers can book appointments.
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            <p class="mb-2"><strong>Please login to book an appointment</strong></p>
                            <a href="{{ route('login') }}" class="btn btn-primary w-100 mb-2">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                            <p class="text-center text-muted mb-0">
                                Don't have an account? <a href="{{ route('register.choice') }}">Register now</a>
                            </p>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        .card.sticky-top {
            position: static !important;
            margin-top: 2rem;
        }
    }
</style>
@endsection
