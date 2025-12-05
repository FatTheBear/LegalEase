@extends('layouts.app')
@section('title', 'View Announcement')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0"><i class="bi bi-megaphone"></i> Announcement Details</h2>
                <p class="text-muted mb-0">View announcement information</p>
            </div>
            <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $announcement->title }}</h5>
                    <span class="badge badge-pill" style="background-color: {{ $announcement->type === 'info' ? '#0dcaf0' : '#6c757d' }}">
                        @if($announcement->type === 'info')
                            <i class="bi bi-info-circle"></i> Information
                        @else
                            <i class="bi bi-chat-dots"></i> General
                        @endif
                    </span>
                </div>
                <div class="card-body">
                    <!-- Image -->
                    @if($announcement->image)
                        <div class="mb-4">
                            <h6 class="text-muted fw-semibold mb-3"><i class="bi bi-image"></i> Featured Image</h6>
                            <img src="{{ asset('storage/' . $announcement->image) }}" alt="{{ $announcement->title }}" class="img-fluid rounded" style="max-height: 400px; width: 100%; object-fit: cover;">
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="mb-4">
                        <h6 class="text-muted fw-semibold mb-3"><i class="bi bi-file-text"></i> Content</h6>
                        <div class="bg-light p-3 rounded" style="line-height: 1.6;">
                            {!! nl2br(e($announcement->content)) !!}
                        </div>
                    </div>

                    <!-- Metadata -->
                    <hr>
                    <div class="row text-muted small">
                        <div class="col-md-6 mb-3">
                            <div class="mb-2">
                                <strong><i class="bi bi-calendar3"></i> Created:</strong><br>
                                <span>{{ $announcement->created_at->format('M d, Y @ h:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light border-top">
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                        <a href="{{ route('admin.announcements.index') }}" class="btn btn-sm btn-secondary">
                            <i class="bi bi-list"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <!-- Type Information -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-tag"></i> Type Information</h6>
                </div>
                <div class="card-body">
                    @if($announcement->type === 'info')
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle"></i> This is an informational announcement
                        </div>
                    @else
                        <div class="alert alert-secondary mb-0">
                            <i class="bi bi-chat-dots"></i> This is a general announcement
                        </div>
                    @endif
                </div>
            </div>

            <!-- Statistics -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-bar-chart"></i> Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="text-muted small mb-1">Total Characters</div>
                        <div class="h5 mb-0">{{ strlen($announcement->content) }}</div>
                    </div>
                    <div class="mb-3">
                        <div class="text-muted small mb-1">Word Count</div>
                        <div class="h5 mb-0">{{ str_word_count($announcement->content) }}</div>
                    </div>
                    <div>
                        <div class="text-muted small mb-1">Days Active</div>
                        <div class="h5 mb-0">{{ $announcement->created_at->diffInDays(now()) }}</div>
                    </div>
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
@endsection
