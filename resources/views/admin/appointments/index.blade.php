@extends('layouts.app')
@section('title', 'Manage Appointments')

@section('content')
<style>
    .card-beige {
        background: linear-gradient(135deg, #a0826d 0%, #8b6f5f 100%);
        border: 0;
        color: white;
    }
    .card-beige .card-text {
        opacity: 0.9;
    }
    .table-header-custom {
        background-color: #3a4b41 !important;
        color: #e6cfa7 !important;
    }
    .table-header-custom th {
        background-color: #3a4b41 !important;
        color: #e6cfa7 !important;
        border-color: #2d3a31 !important;
        font-weight: 600;
        text-align: center;
    }
</style>

<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="w-100 text-center">
            <h2 class="mb-0"><i class="bi bi-calendar-event"></i> Manage Appointments</h2>
            <p class="text-muted mb-0">Manage all appointments of lawyers and clients</p>
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
        <div class="card-body">
            <form method="GET" action="{{ route('admin.appointments.index') }}" class="needs-validation" novalidate>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Search (Name/Email)</label>
                        <input type="text" name="search" class="form-control" 
                               placeholder="Enter name or email..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4 d-flex gap-2 align-items-end">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-search"></i> Search
                        </button>
                        <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary flex-grow-1">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </a>
                    </div>
                </div>
                <div class="row g-3 mt-0">
                    <div class="col-md-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" 
                               value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" 
                               value="{{ request('end_date') }}">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Appointments Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-list-check"></i> Appointments List</h5>
            <small class="text-muted">{{ $appointments->total() }} appointments</small>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-header-custom">
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 15%">Client</th>
                            <th style="width: 15%">Lawyer</th>
                            <th style="width: 15%">Date & Time</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 12%">Created</th>
                            <th style="width: 18%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $index => $appointment)
                        <tr>
                            <td>{{ $appointments->firstItem() + $index }}</td>
                            <td>
                                <div>
                                    <strong>{{ $appointment->client->name ?? 'N/A' }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $appointment->client->email ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $appointment->lawyer->name ?? 'N/A' }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        @if($appointment->lawyer && $appointment->lawyer->lawyerProfile)
                                            {{ $appointment->lawyer->lawyerProfile->specialization ?? 'Specialization' }}
                                        @else
                                            N/A
                                        @endif
                                    </small>
                                </div>
                            </td>
                            <td>
                                <div>
                                    @if($appointment->slot)
                                        <strong>{{ \Carbon\Carbon::parse($appointment->slot->date)->format('m/d/Y') }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($appointment->slot->start_time)->format('H:i') }}
                                            →
                                            {{ \Carbon\Carbon::parse($appointment->slot->end_time)->format('H:i') }}
                                        </small>
                                    @else
                                        <strong>N/A</strong>
                                        <br>
                                        <small class="text-muted">N/A</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($appointment->status === 'pending')
                                    <span class="badge bg-warning"><i class="bi bi-hourglass-split"></i> Pending</span>
                                @elseif($appointment->status === 'confirmed')
                                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> Confirmed</span>
                                @elseif($appointment->status === 'completed')
                                    <span class="badge bg-info"><i class="bi bi-check2-all"></i> Completed</span>
                                @else
                                    <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Cancelled</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $appointment->created_at->format('m/d/Y H:i') }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" 
                                            data-bs-target="#viewModal{{ $appointment->id }}" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <a href="{{ route('admin.appointments.edit', $appointment->id) }}" 
                                       class="btn btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if($appointment->status === 'pending')
                                        <button type="button" class="btn btn-outline-success btn-confirm-appointment" 
                                                data-id="{{ $appointment->id }}" title="Confirm">
                                            <i class="bi bi-check"></i>
                                        </button>
                                    @endif
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" 
                                            data-bs-target="#cancelModal{{ $appointment->id }}" title="Cancel">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- View Modal -->
                        <div class="modal fade" id="viewModal{{ $appointment->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title">
                                            <i class="bi bi-info-circle"></i> Appointment Details
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="text-muted mb-1">Client</h6>
                                                <p class="mb-3">
                                                    <strong>{{ $appointment->client->name ?? 'N/A' }}</strong><br>
                                                    <small class="text-muted">{{ $appointment->client->email ?? 'N/A' }}</small>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="text-muted mb-1">Lawyer</h6>
                                                <p class="mb-3">
                                                    <strong>{{ $appointment->lawyer->name ?? 'N/A' }}</strong><br>
                                                    <small class="text-muted">
                                                        @if($appointment->lawyer && $appointment->lawyer->lawyerProfile)
                                                            {{ $appointment->lawyer->lawyerProfile->specialization ?? 'N/A' }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="text-muted mb-1">Appointment Date</h6>
                                                <p class="mb-3">
                                                    <strong>
                                                        {{ $appointment->slot ? \Carbon\Carbon::parse($appointment->slot->date)->format('m/d/Y') : 'N/A' }}
                                                    </strong>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="text-muted mb-1">Time</h6>
                                                <p class="mb-3">
                                                    <strong>
                                                        {{ $appointment->slot ? \Carbon\Carbon::parse($appointment->slot->start_time)->format('H:i') : 'N/A' }}
                                                        →
                                                        {{ $appointment->slot ? \Carbon\Carbon::parse($appointment->slot->end_time)->format('H:i') : '' }}
                                                    </strong>
                                                </p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="mb-3">
                                            <h6 class="text-muted mb-1">Status</h6>
                                            <p>
                                                @if($appointment->status === 'pending')
                                                    <span class="badge bg-warning"><i class="bi bi-hourglass-split"></i> Pending</span>
                                                @elseif($appointment->status === 'confirmed')
                                                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> Confirmed</span>
                                                @elseif($appointment->status === 'completed')
                                                    <span class="badge bg-info"><i class="bi bi-check2-all"></i> Completed</span>
                                                @else
                                                    <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Cancelled</span>
                                                @endif
                                            </p>
                                        </div>
                                        @if($appointment->notes)
                                            <div class="mb-3">
                                                <h6 class="text-muted mb-1">Notes</h6>
                                                <p class="bg-light p-3 rounded">{{ $appointment->notes }}</p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cancel Modal -->
                        <div class="modal fade" id="cancelModal{{ $appointment->id }}" tabindex="-1">
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
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="text-muted mt-3">No appointments found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($appointments->hasPages())
            <nav class="mt-4">
                {{ $appointments->links() }}
            </nav>
            @endif
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
document.querySelectorAll('.btn-confirm-appointment').forEach(btn => {
    btn.addEventListener('click', function() {
        const appointmentId = this.getAttribute('data-id');
        if (confirm('Are you sure you want to confirm this appointment?')) {
            fetch(`/admin/appointments/${appointmentId}/confirm`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred!');
            });
        }
    });
});
</script>
@endsection
