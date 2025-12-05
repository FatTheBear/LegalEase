@extends('layouts.app')
@section('title', 'Manage Lawyers')

@section('content')
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

    <!-- Search & Sort Bar -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.lawyers') }}" class="d-flex gap-3 align-items-center">
                <div class="input-group" style="max-width: 400px;">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search" 
                           value="{{ request('search') }}">
                </div>

                <select name="status" class="form-select" style="min-width: 150px;">
                    <option value="" disabled selected hidden>Status</option>
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="banned" {{ request('status') === 'banned' ? 'selected' : '' }}>Banned</option>
                </select>

                <select name="specialization" class="form-select" style="min-width: 200px;">
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

                <select name="sort_by" class="form-select" style="min-width: 150px;">
                    <option value="" disabled selected hidden>Sort By</option>
                    <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Date</option>
                    <option value="name" {{ request('sort_by') === 'name' ? 'selected' : '' }}>Name</option>
                    <option value="last_login" {{ request('sort_by') === 'last_login' ? 'selected' : '' }}>Last Active</option>
                </select>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                
                @if(request()->hasAny(['search', 'status', 'specialization', 'sort_by']))
                <a href="{{ route('admin.lawyers') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Clear
                </a>
                @endif
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
                            <th style="width: 12%">Status</th>
                            <th style="width: 15%">Joined Date</th>
                            <th style="width: 8%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lawyers as $index => $lawyer)
                        <tr>
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
                            <td>
                                <a href="{{ route('admin.lawyers.show', $lawyer->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
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
            <div class="d-flex justify-content-center mt-4">
                {{ $lawyers->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection