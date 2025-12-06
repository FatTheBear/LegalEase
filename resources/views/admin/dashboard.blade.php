@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<style>
    .card-beige {
        border: 2px solid #d4a574 !important;
        background-color: #f5f1e8 !important;
    }
    .btn-beige {
        background-color: #a0826d;
        border-color: #a0826d;
        color: white;
    }
    .btn-beige:hover {
        background-color: #8b6f5f;
        border-color: #8b6f5f;
        color: white;
    }

    /* Đã loại bỏ CSS tùy chỉnh dashboard-card-item vì 4 thẻ x 3 cột đã hợp lý */
</style>

<div class="container-fluid">
    <h2 class="mb-4 text-center"><i class="bi bi-speedometer2 "></i> Admin Dashboard</h2>
    
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card card-beige">
                <div class="card-body text-center">
                    <h1 class="display-4" style="color: #5d4037;">{{ $totalUsers }}</h1>
                    <p class="mb-3" style="color: #795548;"><i class="bi bi-people"></i> Total Users</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-beige btn-sm w-100">Manage Users</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-beige">
                <div class="card-body text-center">
                    <h1 class="display-4" style="color: #5d4037;">{{ $totalLawyers }}</h1>
                    <p class="mb-3" style="color: #795548;"><i class="bi bi-briefcase"></i> Total Lawyers</p>
                    <a href="{{ route('admin.lawyers.index') }}" class="btn btn-beige btn-sm w-100">Manage Lawyers</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-beige">
                <div class="card-body text-center">
                    <h1 class="display-4" style="color: #5d4037;">{{ $pendingAppointments }}</h1>
                    <p class="mb-3" style="color: #795548;"><i class="bi bi-calendar"></i> Pending Appointments</p>
                    <a href="{{ route('admin.appointments.index') }}" class="btn btn-beige btn-sm w-100">View Appointments</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card card-beige">
                <div class="card-body text-center">
                    <h1 class="display-4" style="color: #5d4037;">{{ \App\Models\Announcement::count() }}</h1>
                    <p class="mb-3" style="color: #795548;"><i class="bi bi-megaphone"></i> Announcements</p>
                    <a href="{{ route('admin.announcements.index') }}" class="btn btn-beige btn-sm w-100">Announcements</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-beige mb-4 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0" style="color: #5d4037;"><i class="bi bi-star me-2"></i> Manage All Ratings & Reviews</h4>
                <p class="text-muted mb-0">Total Ratings Recorded: <span class="fw-bold">{{ $totalRatings }}</span></p>
            </div>
            <a href="{{ route('admin.ratings.index') }}" class="btn btn-beige px-4">
                View & Manage Ratings
            </a>
        </div>
    </div>
    <div class="card card-beige mb-4 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0" style="color: #5d4037;"><i class="bi bi-calendar2-week me-2"></i> Manage Lawyer Schedules</h4>
                <p class="text-muted mb-0">View and manage all lawyers’ availability slots</p>
            </div>
            <a href="{{ route('admin.lawyer.schedules') }}" class="btn btn-beige px-4">
                Go to Schedules
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="mb-0"><i class="bi bi-list"></i> Recent Lawyer Applications</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Specialization</th>
                            <th>Approval Status</th>
                            <th>Registered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentLawyers as $index => $lawyer)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $lawyer->name }}</td>
                            <td>{{ $lawyer->email }}</td>
                            <td>{{ $lawyer->lawyerProfile->specialization ?? 'N/A' }}</td>
                            <td>
                                @if($lawyer->approval_status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($lawyer->approval_status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>{{ $lawyer->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.lawyers.show', $lawyer->id) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-eye"></i> View Profile
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No lawyer applications yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection