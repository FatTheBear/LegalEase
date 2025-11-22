@extends('layouts.app')
@section('title', 'Edit Appointment')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Appointment</h2>
                <p class="text-muted mb-0">Update appointment information and status</p>
            </div>
            <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i> <strong>Error!</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Left Column - Edit Form -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> Appointment Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.appointments.update', $appointment->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Customer Information -->
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted mb-3">Customer Information</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Customer</label>
                                        <input type="text" class="form-control" 
                                               value="{{ $appointment->customer->name ?? 'N/A' }}" disabled>
                                        <small class="text-muted d-block mt-1">{{ $appointment->customer->email ?? 'N/A' }}</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Phone</label>
                                        <input type="text" class="form-control" 
                                               value="{{ $appointment->customer->customerProfile->phone ?? 'N/A' }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Lawyer Information -->
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted mb-3">Lawyer Information</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Lawyer</label>
                                        <input type="text" class="form-control" 
                                               value="{{ $appointment->lawyer->name ?? 'N/A' }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Specialization</label>
                                        <input type="text" class="form-control" 
                                               value="{{ $appointment->lawyer->lawyerProfile->specialization ?? 'N/A' }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Appointment Information -->
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted mb-3">Appointment Information</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Appointment Time <span class="text-danger">*</span></label>
                                        <input type="datetime-local" name="appointment_time" class="form-control" 
                                               value="{{ $appointment->appointment_time ? $appointment->appointment_time->format('Y-m-d\TH:i') : '' }}"
                                               required>
                                        @error('appointment_time')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                        <select name="status" class="form-select" required>
                                            <option value="">-- Select Status --</option>
                                            <option value="pending" {{ $appointment->status === 'pending' ? 'selected' : '' }}>
                                                <i class="bi bi-hourglass-split"></i> Pending
                                            </option>
                                            <option value="confirmed" {{ $appointment->status === 'confirmed' ? 'selected' : '' }}>
                                                <i class="bi bi-check-circle"></i> Confirmed
                                            </option>
                                            <option value="completed" {{ $appointment->status === 'completed' ? 'selected' : '' }}>
                                                <i class="bi bi-check2-all"></i> Completed
                                            </option>
                                            <option value="cancelled" {{ $appointment->status === 'cancelled' ? 'selected' : '' }}>
                                                <i class="bi bi-x-circle"></i> Cancelled
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Notes -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Notes</label>
                            <textarea name="note" class="form-control" rows="4" 
                                      placeholder="Enter notes about the appointment...">{{ $appointment->note ?? '' }}</textarea>
                            @error('note')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Save Changes
                            </button>
                            <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column - Info -->
        <div class="col-lg-4">
            <!-- Current Status -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-flag"></i> Current Status</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        @if($appointment->status === 'pending')
                            <span class="badge bg-warning p-3 mb-3" style="font-size: 1rem;">
                                <i class="bi bi-hourglass-split"></i> Pending
                            </span>
                        @elseif($appointment->status === 'confirmed')
                            <span class="badge bg-success p-3 mb-3" style="font-size: 1rem;">
                                <i class="bi bi-check-circle"></i> Confirmed
                            </span>
                        @elseif($appointment->status === 'completed')
                            <span class="badge bg-info p-3 mb-3" style="font-size: 1rem;">
                                <i class="bi bi-check2-all"></i> Completed
                            </span>
                        @else
                            <span class="badge bg-danger p-3 mb-3" style="font-size: 1rem;">
                                <i class="bi bi-x-circle"></i> Cancelled
                            </span>
                        @endif
                        <p class="text-muted mb-0 mt-2">Status: <strong>{{ $appointment->status }}</strong></p>
                    </div>
                </div>
            </div>

            <!-- Time Information -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-calendar3"></i> Time Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <p class="text-muted mb-1">Appointment Date</p>
                            <p class="mb-3">
                                <strong>
                                    {{ $appointment->appointment_time ? $appointment->appointment_time->format('m/d/Y') : 'N/A' }}
                                </strong>
                            </p>
                        </div>
                        <div class="col-12">
                            <p class="text-muted mb-1">Time</p>
                            <p class="mb-3">
                                <strong>
                                    {{ $appointment->appointment_time ? $appointment->appointment_time->format('H:i') : 'N/A' }}
                                </strong>
                            </p>
                        </div>
                        <div class="col-12 border-top pt-3">
                            <p class="text-muted mb-1">Created At</p>
                            <p class="mb-0">
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

            <!-- Quick Actions -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-lightning"></i> Quick Actions</h6>
                </div>
                <div class="card-body">
                    @if($appointment->status === 'pending')
                        <form action="{{ route('admin.appointments.confirm', $appointment->id) }}" method="POST" class="mb-2">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success w-100 btn-sm">
                                <i class="bi bi-check-circle"></i> Confirm Now
                            </button>
                        </form>
                    @endif
                    
                    @if($appointment->status !== 'cancelled')
                        <button class="btn btn-danger w-100 btn-sm" data-bs-toggle="modal" data-bs-target="#cancelModal">
                            <i class="bi bi-x-circle"></i> Cancel Appointment
                        </button>
                    @endif
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
