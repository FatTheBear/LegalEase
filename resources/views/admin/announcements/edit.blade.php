@extends('layouts.app')
@section('title', 'Edit Announcement')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Announcement</h2>
                <p class="text-muted mb-0">Update announcement information</p>
            </div>
            <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">
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
                    <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Announcement Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" 
                                   placeholder="Enter announcement title..."
                                   value="{{ old('title', $announcement->title) }}" required>
                            @error('title')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                            <textarea name="content" class="form-control" rows="6"
                                      placeholder="Enter announcement content..."
                                      required>{{ old('content', $announcement->content) }}</textarea>
                            @error('content')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Featured Image</label>
                            
                            @if($announcement->image)
                                <div class="mb-3">
                                    <div class="border rounded p-2">
                                        <img src="{{ asset('storage/' . $announcement->image) }}" alt="Current" class="img-fluid rounded" style="max-height: 200px;">
                                        <small class="text-muted d-block mt-2">Current image</small>
                                    </div>
                                </div>
                            @endif

                            <input type="file" name="image" class="form-control" 
                                   accept="image/jpeg,image/png,image/jpg,image/gif"
                                   id="imageInput">
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-info-circle"></i> Max size: 2MB. Accepted formats: JPEG, PNG, JPG, GIF. Leave empty to keep current image.
                            </small>
                            <div id="imagePreview" class="mt-3"></div>
                            @error('image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Type -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Type</label>
                            <select name="type" class="form-select">
                                <option value="general" {{ old('type', $announcement->type) === 'general' ? 'selected' : '' }}>
                                    <i class="bi bi-chat-dots"></i> General
                                </option>
                                <option value="info" {{ old('type', $announcement->type) === 'info' ? 'selected' : '' }}>
                                    <i class="bi bi-info-circle"></i> Information
                                </option>
                            </select>
                            @error('type')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Save Changes
                            </button>
                            <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">
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
                    <h6 class="mb-0"><i class="bi bi-info-circle"></i> Current Status</h6>
                </div>
                <div class="card-body text-muted small">
                    <div class="mb-3">
                        <div class="text-muted mb-1"><strong>Type:</strong></div>
                        <span class="badge badge-pill" style="background-color: {{ $announcement->type === 'urgent' ? '#dc3545' : ($announcement->type === 'info' ? '#0dcaf0' : '#6c757d') }}">
                            @if($announcement->type === 'urgent')
                                <i class="bi bi-exclamation-triangle"></i> Urgent
                            @elseif($announcement->type === 'info')
                                <i class="bi bi-info-circle"></i> Information
                            @else
                                <i class="bi bi-chat-dots"></i> General
                            @endif
                        </span>
                    </div>
                    <hr>
                    <div>
                        <div class="text-muted mb-1"><strong>Created:</strong></div>
                        <div>{{ $announcement->created_at->format('M d, Y @ h:i A') }}</div>
                    </div>
                </div>
            </div>

            <!-- Type Information -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-lightbulb"></i> Type Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="fw-semibold"><i class="bi bi-chat-dots"></i> General</h6>
                        <small class="text-muted">Regular announcements for all users</small>
                    </div>
                    <hr>
                    <div>
                        <h6 class="fw-semibold"><i class="bi bi-info-circle text-info"></i> Information</h6>
                        <small class="text-muted">Informational updates and notices</small>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-lightning"></i> Quick Actions</h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.announcements.show', $announcement->id) }}" class="btn btn-sm btn-outline-primary btn-block w-100 mb-2">
                        <i class="bi bi-eye"></i> View Details
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-block w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-danger">
                <h5 class="modal-title text-danger"><i class="bi bi-exclamation-triangle"></i> Delete Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this announcement? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        const file = e.target.files[0];
        
        preview.innerHTML = '';
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.innerHTML = `
                    <div class="border rounded p-2">
                        <img src="${event.target.result}" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                        <small class="text-muted d-block mt-2">New file: ${file.name}</small>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
@endsection
