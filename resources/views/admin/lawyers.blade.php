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

    <!-- Lawyers Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-list-check"></i> All Lawyers</h5>
            <small class="text-muted">{{ count($lawyers) }} lawyers</small>
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
                            <th style="width: 15%">Status</th>
                            <th style="width: 15%">Approval</th>
                            <th style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lawyers as $index => $lawyer)
                        <tr>
                            <td>{{ $index + 1 }}</td>
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
                                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> Active</span>
                                @else
                                    <span class="badge bg-warning"><i class="bi bi-pause-circle"></i> Inactive</span>
                                @endif
                            </td>
                            <td>
                                @if($lawyer->approval_status === 'pending')
                                    <span class="badge bg-secondary"><i class="bi bi-hourglass"></i> Pending</span>
                                @elseif($lawyer->approval_status === 'approved')
                                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> Approved</span>
                                @else
                                    <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Rejected</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.lawyers.show', $lawyer->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> View
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
        </div>
    </div>
</div>
@endsection