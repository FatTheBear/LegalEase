@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        {{-- <div class="col-md-3 col-lg-2 bg-light border-end vh-100 sticky-top">
            <div class="p-3">
                <h5 class="text-muted mb-3">Admin Panel</h5>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.users') }}">
                            <i class="bi bi-people"></i> Manage Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.lawyers') }}">
                            <i class="bi bi-briefcase"></i> Manage Lawyers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.appointments') }}">
                            <i class="bi bi-calendar-check"></i> Appointments
                        </a>
                    </li>
                </ul>
            </div>
        </div> --}}

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4">
            <h2 class="mb-4">Admin Dashboard</h2>

            <!-- Statistics Cards -->
            {{-- <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">Total Users</h5>
                            <h2 class="mb-0">{{ \App\Models\User::count() }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Active Lawyers</h5>
                            <h2 class="mb-0">{{ \App\Models\User::where('role', 'lawyer')->count() }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h5 class="card-title">Pending Approvals</h5>
                            <h2 class="mb-0">{{ \App\Models\User::where('role', 'lawyer')->where('approval_status', 'pending')->count() }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <h5 class="card-title">Total Customers</h5>
                            <h2 class="mb-0">{{ \App\Models\User::where('role', 'customer')->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Recent Lawyer Applications -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Lawyer Applications</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Specialization</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                               @forelse(\App\Models\User::where('role', 'lawyer')
    ->where('status', 'active')
    ->latest()
    ->take(5)
    ->get() as $lawyer)
    <tr>
        <td>{{ $lawyer->name }}</td>
        <td>{{ $lawyer->email }}</td>
        <td>{{ $lawyer->lawyerProfile->specialization ?? 'N/A' }}</td>
        <td>
            @if($lawyer->status === 'pending')
                <span class="badge bg-warning">Pending</span>
            @elseif($lawyer->status === 'active')
                <span class="badge bg-success">Active</span>
            @else
                <span class="badge bg-danger">Rejected</span>
            @endif
        </td>
        <td>
            <a href="{{ route('admin.lawyers') }}" class="btn btn-sm btn-primary">View</a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center">No lawyer applications yet</td>
    </tr>
@endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
