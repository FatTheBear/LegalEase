@extends('layouts.app')
@section('title', 'Create Announcement')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0"><i class="bi bi-plus-circle"></i> Create New Announcement</h2>
                <p class="text-muted mb-0">Add a new system-wide announcement</p>
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

    <div class="row">
        <!-- Form Column -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Announcement Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.announcements.store') }}" method="POST">
                        @csrf

                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" 
                                   placeholder="Enter announcement title..."
                                   value="{{ old('title') }}" required>
                            @error('title')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                            <textarea name="content" class="form-control" rows="6"
                                      placeholder="Enter announcement content..."
                                      required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Type -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Type</label>
                            <select name="type" class="form-select">
                                <option value="general" {{ old('type') === 'general' ? 'selected' : '' }}>
                                    <i class="bi bi-chat-dots"></i> General
                                </option>
                                <option value="info" {{ old('type') === 'info' ? 'selected' : '' }}>
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
                                <i class="bi bi-check-circle"></i> Create Announcement
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
            <!-- Type Information -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-info-circle"></i> Announcement Types</h6>
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

            <!-- Tips -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-lightbulb"></i> Tips</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled small">
                        <li class="mb-2">
                            <i class="bi bi-check text-success"></i>
                            Use clear, concise titles
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check text-success"></i>
                            Include all relevant details
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check text-success"></i>
                            Choose appropriate type
                        </li>
                        <li>
                            <i class="bi bi-check text-success"></i>
                            Announcements will be visible to all users
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
