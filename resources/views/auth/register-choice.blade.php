@extends('layouts.app')
@section('title', 'Choose Account Type')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body p-5">
                <h2 class="mb-4 text-center">Choose Account Type</h2>
                <p class="text-center text-muted mb-5">Please select the account type that suits you</p>

                <div class="row g-4">
                    <!-- Customer Registration -->
                    <div class="col-md-6">
                        <div class="card h-100 border-primary" style="cursor: pointer;" onclick="window.location='{{ route('register.customer') }}'">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="bi bi-person-circle" style="font-size: 4rem; color: #0d6efd;"></i>
                                </div>
                                <h4 class="card-title mb-3">Customer</h4>
                                <p class="card-text text-muted">
                                    Register to find lawyers, book appointments, and receive legal consultations
                                </p>
                                <a href="{{ route('register.customer') }}" class="btn btn-primary mt-3">
                                    Register as Customer
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Lawyer Registration -->
                    <div class="col-md-6">
                        <div class="card h-100 border-success" style="cursor: pointer;" onclick="window.location='{{ route('register.lawyer') }}'">
                            <div class="card-body text-center p-4">
                                <div class="mb-3">
                                    <i class="bi bi-briefcase-fill" style="font-size: 4rem; color: #198754;"></i>
                                </div>
                                <h4 class="card-title mb-3">Lawyer</h4>
                                <p class="card-text text-muted">
                                    Register with a professional license to provide legal consultation services
                                </p>
                                <a href="{{ route('register.lawyer') }}" class="btn btn-success mt-3">
                                    Register as Lawyer
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="text-center">
                    <p class="mb-0">Already have an account? 
                        <a href="{{ route('login') }}" class="text-decoration-none fw-bold">
                            Login now
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
