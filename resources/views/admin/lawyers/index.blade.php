@extends('layouts.app')
@section('title', 'Manage Lawyers')

@section('content')
<style>
    .lawyer-row {
        cursor: pointer;
        transition: background-color 0.2s ease;
    }
    .lawyer-row:hover {
        background-color: #f8f9fa !important;
    }
</style>

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="w-100 text-center">
            <h2 class="mb-0"><i class="bi bi-briefcase"></i> Manage Lawyers</h2>
            <p class="text-muted mb-0">View and manage all registered lawyers</p>
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
            <form method="GET" action="{{ route('admin.lawyers.index') }}" class="needs-validation" novalidate>
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Enter name or email..." 
                               value="{{ request('search') }}">
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
                        <a href="{{ route('admin.lawyers.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Lawyers Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-list-check"></i> All Lawyers</h5>
            <small class="text-muted">{{ $lawyers->total() }} lawyers</small>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 20%">Name</th>
                            <th style="width: 20%">Email</th>
                            <th style="width: 15%">Specialization</th>
                            <th style="width: 10%">Experience</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 10%">Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lawyers as $index => $lawyer)
                        <tr class="lawyer-row" onclick="window.location.href='{{ route('admin.lawyers.edit', $lawyer->id) }}'">
                            <td>{{ $lawyers->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $lawyer->name }}</strong>
                            </td>
                            <td>
                                <small class="text-muted">{{ $lawyer->email }}</small>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $lawyer->lawyerProfile?->specialization ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <small>{{ $lawyer->lawyerProfile?->experience_years ?? 0 }} years</small>
                            </td>
                            <td>
                                @if($lawyer->status === 'active')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Active
                                    </span>
                                @elseif($lawyer->status === 'inactive')
                                    <span class="badge bg-warning">
                                        <i class="bi bi-pause-circle"></i> Inactive
                                    </span>
                                @elseif($lawyer->status === 'pending')
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
                                <small class="text-muted">{{ $lawyer->created_at->format('M d, Y') }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="text-muted mt-3">No lawyers found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($lawyers->hasPages())
            <nav class="mt-4">
                {{ $lawyers->links('pagination::bootstrap-5') }}
            </nav>
            @endif
        </div>
    </div>
</div>
@endsection
