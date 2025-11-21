@extends('layouts.app')
@section('title', 'Customer Dashboard')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Customer Dashboard</h2>
    
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-search" style="font-size: 3rem; color: #0d6efd;"></i>
                    <h5 class="card-title mt-3">Find Lawyers</h5>
                    <p class="card-text">Search for lawyers by specialization</p>
                    <a href="{{ route('lawyers.index') }}" class="btn btn-primary">Search Now</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-calendar-check" style="font-size: 3rem; color: #198754;"></i>
                    <h5 class="card-title mt-3">My Appointments</h5>
                    <p class="card-text">View and manage your bookings</p>
                    <a href="{{ route('appointments.index') }}" class="btn btn-success">View Appointments</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-person-circle" style="font-size: 3rem; color: #ffc107;"></i>
                    <h5 class="card-title mt-3">My Profile</h5>
                    <p class="card-text">Update your personal information</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-warning">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Appointments -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Recent Appointments</h5>
        </div>
        <div class="card-body">
            <p class="text-muted">No appointments yet. <a href="{{ route('lawyers.index') }}">Book your first consultation!</a></p>
        </div>
    </div>
</div>
@endsection
