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
                    <h2 class="mb-0">{{ $totalAppointments }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Pending Appointments</h5>
                    <h2 class="mb-0">{{ $pendingAppointments }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Average Rating</h5>
                    <h2 class="mb-0">{{ $averageRating ? number_format($averageRating, 1) : 'N/A' }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Average Rating</h5>
                    <h2 class="mb-0">{{ $averageRating ? number_format($averageRating, 1) . ' ⭐' : 'N/A' }}</h2>
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
                    <a href="{{ route('lawyer.schedule') }}" class="btn btn-success">Manage Schedule</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-person-badge" style="font-size: 3rem; color: #ffc107;"></i>
                    <h5 class="card-title mt-3">My Profile</h5>
                    <p class="card-text">Update your professional information</p>
                    <a href="{{ route('lawyer.profile.edit') }}" class="btn btn-warning">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Appointments -->
    <div class="card mt-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Upcoming Appointments</h5>
    </div>
    <div class="card-body">
        @if($appointments->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Date & Time</th>
                        <th>Client</th>
                        <th>Status</th>
                        <th>View</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appt)
                    <tr>
                        <td>
                            {{ \Carbon\Carbon::parse($appt->appointment_time)->format('d/m/Y H:i') }}
                        </td>
                        <td>{{ $appt->client->name ?? 'N/A' }}</td>
                        <td>
                            @if($appt->status === 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($appt->status === 'confirmed')
                                <span class="badge bg-success">Confirmed</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('appointments.index', $appt->id) }}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5 text-muted">
            <i class="bi bi-calendar-x" style="font-size: 4rem;"></i>
            <p class="mt-3">No upcoming appointments.</p>
        </div>
        @endif
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
