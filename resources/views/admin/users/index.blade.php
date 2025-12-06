@extends('layouts.app')
@section('title', 'Manage Users')

@section('content')
<style>
    .user-row {
        cursor: pointer;
        transition: background-color 0.2s ease;
    }
    .user-row:hover {
        background-color: #f8f9fa !important;
    }
</style>

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="w-100 text-center">
            <h2 class="mb-0"><i class="bi bi-people"></i> Manage Users</h2>
            <p class="text-muted mb-0">View and manage all system users</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light border-bottom">
            <h5 class="mb-0"><i class="bi bi-funnel"></i> Search & Filter</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}" class="needs-validation" novalidate>
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Enter name or email..." 
                               value="{{ request('search') }}">
                    </div>
                    
                    <div class="col-md-2">
                        <select name="role" class="form-select">
                            <option value="">-- All Roles --</option>
                            <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">-- All Status --</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="banned" {{ request('status') === 'banned' ? 'selected' : '' }}>Banned</option>
                        </select>
                    </div>

                    <div class="col-md-4 d-flex gap-2 align-items-end">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-search"></i> Search
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-list-check"></i> All Users</h5>
            <small class="text-muted">{{ $users->total() }} users</small>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 25%">Name</th>
                            <th style="width: 25%">Email</th>
                            <th style="width: 15%">Role</th>
                            <th style="width: 15%">Status</th>
                            <th style="width: 15%">Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                        <tr class="user-row" onclick="window.location.href='{{ route('admin.users.edit', $user->id) }}'">
                            <td>{{ $users->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $user->name }}</strong>
                            </td>
                            <td>
                                <small class="text-muted">{{ $user->email }}</small>
                            </td>
                            <td>
                                <span class="badge bg-success">
                                    <i class="bi bi-person"></i> Customer
                                </span>
                            </td>
                            <td>
                                @if($user->status === 'active')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Active
                                    </span>
                                @elseif($user->status === 'inactive')
                                    <span class="badge bg-warning">
                                        <i class="bi bi-pause-circle"></i> Inactive
                                    </span>
                                @elseif($user->status === 'pending')
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-hourglass"></i> Pending
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="bi bi-ban"></i> Banned
                                    </span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $user->created_at->format('M d, Y') }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="text-muted mt-3">No users found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
            <nav class="mt-4">
                {{ $users->links( 'pagination::bootstrap-5') }}
            </nav>
            @endif
        </div>
    </div>
</div>
@endsection
