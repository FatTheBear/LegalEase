@extends('layouts.app')
@section('title', 'Edit User')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0"><i class="bi bi-pencil-square"></i> Edit User</h2>
                <p class="text-muted mb-0">Update user information</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
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

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Form Column -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0"><i class="bi bi-person"></i> User Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" 
                                   placeholder="Enter user name..."
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" 
                                   placeholder="Enter email address..."
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>
                                    <i class="bi bi-check-circle"></i> Active
                                </option>
                                <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>
                                    <i class="bi bi-pause-circle"></i> Inactive
                                </option>
                                <option value="pending" {{ old('status', $user->status) === 'pending' ? 'selected' : '' }}>
                                    <i class="bi bi-hourglass"></i> Pending
                                </option>
                                <option value="banned" {{ old('status', $user->status) === 'banned' ? 'selected' : '' }}>
                                    <i class="bi bi-ban"></i> Banned
                                </option>
                            </select>
                            @error('status')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Save Changes
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Column -->
        <div class="col-lg-4">
            <!-- Current Status -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-info-circle"></i> Current Information</h6>
                </div>
                <div class="card-body text-muted small">
                    <div class="mb-3">
                        <div class="text-muted mb-1"><strong>Role:</strong></div>
                        <div>
                            @if($user->role === 'customer')
                                <span class="badge bg-info"><i class="bi bi-person"></i> Customer</span>
                            @elseif($user->role === 'lawyer')
                                <span class="badge bg-warning"><i class="bi bi-briefcase"></i> Lawyer</span>
                            @else
                                <span class="badge bg-dark"><i class="bi bi-shield"></i> Admin</span>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <div class="text-muted mb-1"><strong>Status:</strong></div>
                        <div>
                            @if($user->status === 'active')
                                <span class="badge bg-success"><i class="bi bi-check-circle"></i> Active</span>
                            @elseif($user->status === 'inactive')
                                <span class="badge bg-warning"><i class="bi bi-pause-circle"></i> Inactive</span>
                            @elseif($user->status === 'pending')
                                <span class="badge bg-secondary"><i class="bi bi-hourglass"></i> Pending</span>
                            @else
                                <span class="badge bg-danger"><i class="bi bi-ban"></i> Banned</span>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <div class="text-muted mb-1"><strong>Registered:</strong></div>
                        <div>{{ $user->created_at->format('M d, Y @ h:i A') }}</div>
                    </div>
                    <hr>
                    <div>
                        <div class="text-muted mb-1"><strong>Last Updated:</strong></div>
                        <div>{{ $user->updated_at->format('M d, Y @ h:i A') }}</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-lightning"></i> Quick Actions</h6>
                </div>
                <div class="card-body">
                    @if($user->status !== 'active')
                        <form action="{{ route('admin.users.activate', $user->id) }}" method="POST" class="mb-2">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-success w-100">
                                <i class="bi bi-play-circle"></i> Activate User
                            </button>
                        </form>
                    @endif

                    @if($user->status === 'active')
                        <form action="{{ route('admin.users.deactivate', $user->id) }}" method="POST" class="mb-2">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-warning w-100">
                                <i class="bi bi-pause-circle"></i> Deactivate User
                            </button>
                        </form>
                    @endif

                    @if($user->status !== 'banned')
                        <button type="button" class="btn btn-sm btn-danger w-100" data-bs-toggle="modal" data-bs-target="#banModal">
                            <i class="bi bi-ban"></i> Ban User
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ban Modal -->
<div class="modal fade" id="banModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light border-danger">
                <h5 class="modal-title text-danger">
                    <i class="bi bi-exclamation-triangle"></i> Ban User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.users.ban', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <p class="text-muted">Are you sure you want to ban this user?</p>
                    <p class="fw-bold">{{ $user->name }}</p>
                    <p class="small text-muted">{{ $user->email }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-ban"></i> Ban User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
