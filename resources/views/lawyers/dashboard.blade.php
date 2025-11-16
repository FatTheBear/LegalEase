@extends('layouts.app')
@section('title', 'Lawyer Dashboard')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Welcome, {{ Auth::user()->name }}</h2>
    
    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Appointments</h5>
                    <h2 class="mb-0">{{ $pending + $completed }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Pending</h5>
                    <h2 class="mb-0">{{ $pending }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Completed</h5>
                    <h2 class="mb-0">{{ $completed }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Average Rating</h5>
                    <h2 class="mb-0">{{ number_format($rating, 1) }} ⭐</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-calendar-check" style="font-size: 3rem; color: #0d6efd;"></i>
                    <h5 class="card-title mt-3">View Appointments</h5>
                    <p class="card-text">Manage your bookings and schedule</p>
                    <a href="{{ route('appointments.index') }}" class="btn btn-primary">View Appointments</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-calendar-plus" style="font-size: 3rem; color: #198754;"></i>
                    <h5 class="card-title mt-3">Manage Availability</h5>
                    <p class="card-text">Set your available time slots</p>
                    <a href="#" class="btn btn-success">Manage Schedule</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-person-badge" style="font-size: 3rem; color: #ffc107;"></i>
                    <h5 class="card-title mt-3">My Profile</h5>
                    <p class="card-text">Update your professional information</p>
                    <a href="#" class="btn btn-warning">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Schedule -->
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Today's Schedule</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Client</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center text-muted">No appointments scheduled for today</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Client Reviews -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Recent Client Reviews</h5>
        </div>
        <div class="card-body">
            <p class="text-muted">No reviews yet</p>
        </div>
    </div>
</div>
@endsection
