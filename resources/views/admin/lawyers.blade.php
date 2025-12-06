@extends('layouts.app')
@section('title', 'Manage Lawyers')

@section('content')
<style>
    .pagination {
        margin: 0;
    }
    .pagination .page-link {
        color: #3a4b41;
        border: 1px solid #dee2e6;
        padding: 0.5rem 0.75rem;
        margin: 0 2px;
        border-radius: 4px;
    }
    .pagination .page-link:hover {
        background-color: #e6cfa7;
        border-color: #e6cfa7;
        color: #3a4b41;
    }
    .pagination .page-item.active .page-link {
        background-color: #3a4b41;
        border-color: #3a4b41;
        color: white;
    }
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #fff;
        border-color: #dee2e6;
    }
    .table-hover tbody tr:hover td {
        background-color: #f5f5f5 !important;
    }
    .table tbody tr {
        transition: background-color 0.2s ease;
    }
    table tbody tr:hover {
        background-color: #f5f5f5 !important;
    }
    table tbody tr {
        cursor: pointer;
    }
</style>

<div class="container-fluid py-4 text-center">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4 text-center">
        <div class="w-100 text-center">
            <h2 class="mb-0 text-center"><i class="bi bi-briefcase"></i> Manage Lawyers</h2>
            <p class="text-muted mb-0">View and manage all lawyer accounts</p>
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

    <!-- Search Bar -->
    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.lawyers.index') }}" class="d-flex gap-3 align-items-center">
                <div class="input-group" style="max-width: 400px;">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search" 
                           value="{{ request('search') }}">
                </div>

                <select name="status" class="form-select" style="width: 150px;">
                    <option value="" disabled selected hidden>Status</option>
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="banned" {{ request('status') === 'banned' ? 'selected' : '' }}>Banned</option>
                </select>

                <select name="specialization" class="form-select" style="width: 200px;">
                    <option value="" disabled selected hidden>Specialization</option>
                    <option value="">All Specializations</option>
                    <option value="Criminal Law" {{ request('specialization') === 'Criminal Law' ? 'selected' : '' }}>Criminal Law</option>
                    <option value="Civil Law" {{ request('specialization') === 'Civil Law' ? 'selected' : '' }}>Civil Law</option>
                    <option value="Family Law" {{ request('specialization') === 'Family Law' ? 'selected' : '' }}>Family Law</option>
                    <option value="Corporate Law" {{ request('specialization') === 'Corporate Law' ? 'selected' : '' }}>Corporate Law</option>
                    <option value="Labor Law" {{ request('specialization') === 'Labor Law' ? 'selected' : '' }}>Labor Law</option>
                    <option value="Real Estate Law" {{ request('specialization') === 'Real Estate Law' ? 'selected' : '' }}>Real Estate Law</option>
                    <option value="Intellectual Property" {{ request('specialization') === 'Intellectual Property' ? 'selected' : '' }}>Intellectual Property</option>
                    <option value="Tax Law" {{ request('specialization') === 'Tax Law' ? 'selected' : '' }}>Tax Law</option>
                    <option value="Immigration Law" {{ request('specialization') === 'Immigration Law' ? 'selected' : '' }}>Immigration Law</option>
                    <option value="Environmental Law" {{ request('specialization') === 'Environmental Law' ? 'selected' : '' }}>Environmental Law</option>
                    <option value="Contract Law" {{ request('specialization') === 'Contract Law' ? 'selected' : '' }}>Contract Law</option>
                    <option value="Administrative Law" {{ request('specialization') === 'Administrative Law' ? 'selected' : '' }}>Administrative Law</option>
                </select>

                <button type="submit" class="btn btn-primary" style="width: 150px; height: 38px; background-color: #3a4b41; border-color: #3a4b41;">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                
                @if(request()->hasAny(['search', 'status', 'specialization']))
                <a href="{{ route('admin.lawyers.index') }}" class="btn btn-primary" style="width: 150px; height: 38px; background-color: #3a4b41; border-color: #3a4b41;">
                    <i class="bi bi-x-circle"></i> Clear
                </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Lawyers Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr style="background-color: #3a4b41 !important;">
                            <th style="width: 5%; background-color: #3a4b41 !important; color: #e6cfa7 !important; border-color: #3a4b41 !important;">No.</th>
                            <th style="width: 22%; background-color: #3a4b41 !important; color: #e6cfa7 !important; border-color: #3a4b41 !important;">Name</th>
                            <th style="width: 25%; background-color: #3a4b41 !important; color: #e6cfa7 !important; border-color: #3a4b41 !important;">Email</th>
                            <th style="width: 18%; background-color: #3a4b41 !important; color: #e6cfa7 !important; border-color: #3a4b41 !important;">Specialization</th>
                            <th style="width: 12%; background-color: #3a4b41 !important; color: #e6cfa7 !important; border-color: #3a4b41 !important;">Status</th>
                            <th style="width: 18%; background-color: #3a4b41 !important; color: #e6cfa7 !important; border-color: #3a4b41 !important;">Joined Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lawyers as $index => $lawyer)
                        <tr onclick="window.location.href='{{ route('admin.lawyers.show', $lawyer->id) }}'" style="cursor: pointer;">
                            <td>{{ $lawyers->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $lawyer->name }}</strong>
                            </td>
                            <td>
                                <small class="text-muted">{{ $lawyer->email }}</small>
                            </td>
                            <td>
                                <small>{{ $lawyer->lawyerProfile->specialization ?? 'N/A' }}</small>
                            </td>
                            <td>
                                @if($lawyer->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($lawyer->status === 'inactive')
                                    <span class="badge bg-secondary">Inactive</span>
                                @elseif($lawyer->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-danger">Banned</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $lawyer->created_at->format('M d, Y') }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
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
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted small">
                    Showing {{ $lawyers->firstItem() }} to {{ $lawyers->lastItem() }} of {{ $lawyers->total() }} results
                </div>
                <nav aria-label="Page navigation">
                    {{ $lawyers->appends(request()->query())->links('pagination::bootstrap-4') }}
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection