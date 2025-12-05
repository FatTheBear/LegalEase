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
            <form method="GET" action="{{ url('/admin/lawyers') }}" class="needs-validation" novalidate>
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
                        <a href="{{ url('/admin/lawyers') }}" class="btn btn-secondary">
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
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 3%"><input type="checkbox"></th>
                            <th style="width: 15%">Full Name</th>
                            <th style="width: 20%">Email</th>
                            <th style="width: 12%">Status</th>
                            <th style="width: 12%">Role</th>
                            <th style="width: 15%">Joined Date</th>
                            <th style="width: 15%">Last Active</th>
                            <th style="width: 8%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lawyers as $index => $lawyer)
                        <tr class="lawyer-row">
                            <td><input type="checkbox"></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://i.pravatar.cc/32?u={{ $lawyer->email }}" alt="{{ $lawyer->name }}" class="rounded-circle" width="32" height="32">
                                    <strong>{{ $lawyer->name }}</strong>
                                </div>
                            </td>
                            <td>
                                <small class="text-muted">{{ $lawyer->email }}</small>
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
                                <span class="badge bg-info text-dark">{{ ucfirst($lawyer->role) }}</span>
                            </td>
                            <td>
                                <small>{{ $lawyer->created_at->format('M d, Y') }}</small>
                            </td>
                            <td>
                                <small class="text-muted">
                                    @if($lawyer->updated_at)
                                        {{ $lawyer->updated_at->diffForHumans() }}
                                    @else
                                        Never
                                    @endif
                                </small>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ url('/admin/lawyers/' . $lawyer->id) }}" class="btn btn-sm btn-outline-primary" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ url('/admin/lawyers/' . $lawyer->id . '/edit') }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ url('/admin/lawyers/' . $lawyer->id) }}" method="POST" style="display: inline;" onclick="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
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
