@extends('layouts.app')
@section('title', 'Appointment Details')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0"><i class="bi bi-info-circle"></i> Appointment Details</h2>
                <p class="text-muted mb-0">View full appointment information</p>
            </div>
            <div class="btn-group" role="group">
                <a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Info -->
        <div class="col-lg-8">
            <!-- Customer -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-person"></i> Customer Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Customer Name</p>
                            <p class="mb-3"><strong>{{ $appointment->customer->name ?? 'N/A' }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Email</p>
                            <p class="mb-3"><strong>{{ $appointment->customer->email ?? 'N/A' }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Phone</p>
                            <p class="mb-3"><strong>{{ $appointment->customer->customerProfile->phone ?? 'N/A' }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Account Status</p>
                            <p class="mb-3">
                                @if($appointment->customer->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lawyer -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-briefcase"></i> Lawyer Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Lawyer Name</p>
                            <p class="mb-3"><strong>{{ $appointment->lawyer->name ?? 'N/A' }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Email</p>
                            <p class="mb-3"><strong>{{ $appointment->lawyer->email ?? 'N/A' }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Specialization</p>
                            <p class="mb-3"><strong>{{ $appointment->lawyer->lawyerProfile->specialization ?? 'N/A' }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Status</p>
                            <p class="mb-3">
                                @if($appointment->lawyer->approval_status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($appointment->lawyer->approval_status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appointment Details -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-calendar-event"></i> Appointment Details</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Appointment Date</p>
                            <p class="mb-3">
                                <strong>
                                    {{ $appointment->appointment_time ? $appointment->appointment_time->format('m/d/Y') : 'N/A' }}
                                </strong>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Time</p>
                            <p class="mb-3">
                                <strong>
                                    {{ $appointment->appointment_time ? $appointment->appointment_time->format('H:i') : 'N/A' }}
                                </strong>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Status</p>
                            <p class="mb-3">
                                @if($appointment->status === 'pending')
                                    <span class="badge bg-warning">
                                        <i class="bi bi-hourglass-split"></i> Pending
                                    </span>
                                @elseif($appointment->status === 'confirmed')
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> Confirmed
                                    </span>
                                @elseif($appointment->status === 'completed')
                                    <span class="badge bg-info">
                                        <i class="bi bi-check2-all"></i> Completed
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="bi bi-x-circle"></i> Cancelled
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Time Remaining</p>
                            <p class="mb-3">
                                <strong>
                                    @if($appointment->appointment_time)
                                        @if($appointment->appointment_time > now())
                                            {{ $appointment->appointment_time->diffForHumans() }}
                                        @else
                                            Passed
                                        @endif
                                    @else
                                        N/A
                                    @endif
                                </strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if($appointment->note)
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-sticky"></i> Notes</h6>
                </div>
                <div class="card-body">
                    <div class="bg-light p-3 rounded">
                        {{ $appointment->note }}
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Status -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-flag"></i> Status</h6>
                </div>
                <div class="card-body text-center">
                    @if($appointment->status === 'pending')
                        <span class="badge bg-warning p-3 mb-3" style="font-size: 1.2rem;">
                            <i class="bi bi-hourglass-split"></i> Pending
                        </span>
                    @elseif($appointment->status === 'confirmed')
                        <span class="badge bg-success p-3 mb-3" style="font-size: 1.2rem;">
                            <i class="bi bi-check-circle"></i> Confirmed
                        </span>
                    @elseif($appointment->status === 'completed')
                        <span class="badge bg-info p-3 mb-3" style="font-size: 1.2rem;">
                            <i class="bi bi-check2-all"></i> Completed
                        </span>
                    @else
                        <span class="badge bg-danger p-3 mb-3" style="font-size: 1.2rem;">
                            <i class="bi bi-x-circle"></i> Cancelled
                        </span>
                    @endif
                </div>
            </div>

            <!-- History -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-clock-history"></i> History</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <p class="text-muted mb-1">Created At</p>
                            <p class="mb-3">
                                <small>{{ $appointment->created_at->format('m/d/Y H:i') }}</small>
                            </p>
                        </div>
                        <div class="col-12">
                            <p class="text-muted mb-1">Last Updated</p>
                            <p class="mb-0">
                                <small>{{ $appointment->updated_at->format('m/d/Y H:i') }}</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-lightning"></i> Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.appointments.edit', $appointment->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        @if($appointment->status === 'pending')
                            <form action="{{ route('admin.appointments.confirm', $appointment->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success btn-sm w-100">
                                    <i class="bi bi-check-circle"></i> Confirm
                                </button>
                            </form>
                        @endif
                        @if($appointment->status !== 'cancelled')
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#cancelModal">
                                <i class="bi bi-x-circle"></i> Cancel
                            </button>
                        @endif
                        <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light border-danger">
                <h5 class="modal-title text-danger">
                    <i class="bi bi-exclamation-triangle"></i> Confirm Cancel Appointment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.appointments.cancel', $appointment->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <p class="text-muted">Are you sure you want to cancel this appointment?</p>
                    <div class="mb-3">
                        <label class="form-label">Reason (Optional)</label>
                        <textarea name="reason" class="form-control" rows="3" 
                                  placeholder="Enter reason for cancellation..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-x-circle"></i> Cancel Appointment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
