@extends('layouts.app')
@section('title', 'Lawyer Profile')

@section('content')
<div class="container mt-4">
    <!-- Flash Messages -->
    @if($message = session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: #e6cfa7; color: #3a4b41; border: none;">
            <strong><i class="bi bi-check-circle"></i> Success!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($message = session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background-color: #3a4b41; color: #e6cfa7; border: none;">
            <strong><i class="bi bi-exclamation-circle"></i> Error!</strong> {{ $message }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="glyphicon glyphicon-user"></i> Lawyer Profile Details
                        <a href="{{ url('/admin/lawyers') }}" class="btn btn-default btn-sm pull-right">
                            <i class="glyphicon glyphicon-arrow-left"></i> Back to List
                        </a>
                    </h3>
                </div>
                <div class="panel-body">
                    <!-- Basic Info -->
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Basic Information</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Name</th>
                                    <td>{{ $lawyer->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $lawyer->email }}</td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td><span class="label label-info">{{ ucfirst($lawyer->role) }}</span></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($lawyer->status == 'active')
                                            <span class="label label-success">Active</span>
                                        @else
                                            <span class="label label-warning">{{ ucfirst($lawyer->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Approval Status</th>
                                    <td>
                                        @if($lawyer->approval_status == 'approved')
                                            <span class="label label-success">Approved</span>
                                        @elseif($lawyer->approval_status == 'pending')
                                            <span class="label label-warning">Pending</span>
                                        @else
                                            <span class="label label-danger">Rejected</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Email Verified</th>
                                    <td>
                                        @if($lawyer->email_verified_at)
                                            <span class="label label-success">✓ Verified</span>
                                            <br><small>{{ $lawyer->email_verified_at->format('M d, Y H:i') }}</small>
                                        @else
                                            <span class="label label-danger">Not Verified</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Joined Date</th>
                                    <td>{{ $lawyer->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Active</th>
                                    <td>{{ $lawyer->last_login_at ? $lawyer->last_login_at->format('M d, Y H:i') : 'Never' }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h4>Professional Information</h4>
                            @if($lawyer->lawyerProfile)
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">Specialization</th>
                                        <td>{{ $lawyer->lawyerProfile->specialization ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Experience</th>
                                        <td>{{ $lawyer->lawyerProfile->experience ?? 0 }} years</td>
                                    </tr>
                                    <tr>
                                        <th>Bio</th>
                                        <td>{{ $lawyer->lawyerProfile->bio ?? 'No bio available' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Province</th>
                                        <td>{{ $lawyer->lawyerProfile->province ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                            @else
                                <div class="alert alert-info">
                                    <i class="glyphicon glyphicon-info-sign"></i> No professional profile created yet.
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <!-- Documents/Certificates Section -->
                    <div class="row">
                        <div class="col-md-12">
                            <h4><i class="glyphicon glyphicon-file"></i> Uploaded Documents & Certificates</h4>
                            
                            @if($lawyer->documents && $lawyer->documents->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="bg-info">
                                            <tr>
                                                <th>#</th>
                                                <th>File Name</th>
                                                <th>Type</th>
                                                <th>Size</th>
                                                <th>Uploaded Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($lawyer->documents as $index => $document)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <i class="glyphicon glyphicon-file"></i>
                                                        {{ $document->file_name }}
                                                    </td>
                                                    <td>
                                                        <span class="label label-info">{{ ucfirst($document->document_type) }}</span>
                                                        <br>
                                                        <small class="text-muted">{{ strtoupper($document->file_extension) }}</small>
                                                    </td>
                                                    <td>{{ $document->formatted_size }}</td>
                                                    <td>{{ $document->created_at->format('M d, Y H:i') }}</td>
                                                    <td>
                                                        @if(in_array($document->file_extension, ['jpg', 'jpeg', 'png', 'gif']))
                                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#imageModal{{ $document->id }}">
                                                                <i class="bi bi-eye"></i> View
                                                            </button>
                                                        @else
                                                            <a href="{{ Storage::url($document->file_path) }}" class="btn btn-sm btn-primary" target="_blank">
                                                                <i class="bi bi-download"></i> Download
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>

                                                <!-- Image Modal for Preview -->
                                                @if(in_array($document->file_extension, ['jpg', 'jpeg', 'png', 'gif']))
                                                    <div class="modal fade" id="imageModal{{ $document->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">{{ $document->file_name }}</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    <img src="{{ Storage::url($document->file_path) }}" alt="{{ $document->file_name }}" class="img-fluid" style="max-height: 600px;">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a href="{{ Storage::url($document->file_path) }}" class="btn btn-primary" download>
                                                                        <i class="bi bi-download"></i> Download
                                                                    </a>
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="glyphicon glyphicon-exclamation-sign"></i> No documents uploaded yet.
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr>
                    <!-- Status Management Section -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4><i class="bi bi-sliders"></i> Status Management</h4>
                            
                            @if($lawyer->approval_status == 'pending')
                                <div class="alert alert-warning">
                                    <h5><i class="glyphicon glyphicon-exclamation-sign"></i> Action Required</h5>
                                    <p>This lawyer application is pending approval. Please review the information and take action.</p>
                                    
                                    <div class="d-flex gap-2 flex-wrap">
                                        <form action="{{ url('/admin/lawyers/' . $lawyer->id . '/approve') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to approve this lawyer?')">
                                                <i class="glyphicon glyphicon-ok"></i> Approve
                                            </button>
                                        </form>

                                        <form action="{{ url('/admin/lawyers/' . $lawyer->id . '/reject') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to reject this lawyer?')">
                                                <i class="glyphicon glyphicon-remove"></i> Reject
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3 align-items-center">
                                            <div class="col-md-3">
                                                <label class="form-label fw-bold">Current Status:</label>
                                                <p class="mb-0">
                                                    @if($lawyer->status == 'active')
                                                        <span class="badge bg-success">Active</span>
                                                    @elseif($lawyer->status == 'banned')
                                                        <span class="badge bg-danger">Banned</span>
                                                    @else
                                                        <span class="badge bg-warning">{{ ucfirst($lawyer->status) }}</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="col-md-9">
                                                @if($lawyer->status === 'banned')
                                                    <div class="alert alert-danger mb-0">
                                                        <i class="bi bi-exclamation-triangle"></i> 
                                                        <strong>This account has been banned by the system.</strong>
                                                        <p class="mb-0 small">The account exists in the database but is restricted from accessing the system.</p>
                                                    </div>
                                                @else
                                                    <label class="form-label fw-bold d-block">Change Status:</label>
                                                    <div class="d-flex gap-2 flex-wrap">
                                                        @if($lawyer->status !== 'active')
                                                            <form action="{{ route('admin.lawyers.update-status', $lawyer->id) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                <input type="hidden" name="status" value="active">
                                                                <button type="submit" class="btn btn-sm btn-success">
                                                                    <i class="bi bi-check-circle"></i> Activate
                                                                </button>
                                                            </form>
                                                        @endif

                                                        <form id="banForm" action="{{ route('admin.lawyers.update-status', $lawyer->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="banned">
                                                        </form>
                                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#banModal">
                                                            <i class="bi bi-exclamation-circle"></i> Ban
                                                        </button>

                                                        @if($lawyer->status !== 'inactive')
                                                            <form id="deactivateForm" action="{{ route('admin.lawyers.update-status', $lawyer->id) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="inactive">
                                                            </form>
                                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#deactivateModal">
                                                                <i class="bi bi-pause-circle"></i> Deactivate
                                                            </button>
                                                        @endif

                                                        <form id="deleteForm" action="{{ route('admin.lawyers.delete', $lawyer->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                            <i class="bi bi-trash"></i> Delete
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ban Confirmation Modal -->
<div class="modal fade" id="banModal" tabindex="-1" aria-labelledby="banModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="banModalLabel">
                    <i class="bi bi-exclamation-triangle"></i> Confirm Ban
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">Are you sure you want to ban this lawyer?</p>
                <p class="text-muted small mb-3">This action will prevent the lawyer from accessing the system and an email notification will be sent.</p>
                
                <div class="mb-3">
                    <label for="banReasonSelect" class="form-label fw-bold">Select Ban Reason:</label>
                    <select class="form-select" id="banReasonSelect" name="ban_reason_id" required>
                        <option value="">-- Choose a reason --</option>
                        @foreach(\App\Models\BanReason::all() as $reason)
                            <option value="{{ $reason->id }}">{{ $reason->reason }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" onclick="submitBanForm();">
                    <i class="bi bi-exclamation-circle"></i> Yes, Ban Lawyer
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-trash"></i> Confirm Delete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this lawyer?</p>
                <p class="text-danger small mb-0"><strong>This action cannot be undone.</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="document.getElementById('deleteForm').submit();">
                    <i class="bi bi-trash"></i> Yes, Delete Lawyer
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Deactivate Confirmation Modal -->
<div class="modal fade" id="deactivateModal" tabindex="-1" aria-labelledby="deactivateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="deactivateModalLabel">
                    <i class="bi bi-pause-circle"></i> Confirm Deactivate
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to deactivate this lawyer?</p>
                <p class="text-muted small mb-0">The lawyer will not be able to receive new appointments but their profile will remain in the system.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('deactivateForm').submit();">
                    <i class="bi bi-pause-circle"></i> Yes, Deactivate Lawyer
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function submitBanForm() {
    const reasonSelect = document.getElementById('banReasonSelect');
    const selectedReason = reasonSelect.value;
    
    if (!selectedReason) {
        alert('Please select a ban reason.');
        return;
    }
    
    // Thêm ban_reason_id vào form
    const form = document.getElementById('banForm');
    const reasonInput = document.createElement('input');
    reasonInput.type = 'hidden';
    reasonInput.name = 'ban_reason_id';
    reasonInput.value = selectedReason;
    form.appendChild(reasonInput);
    
    // Submit form
    form.submit();
}
</script>
@endsection
