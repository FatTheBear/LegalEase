@extends('layouts.app')
@section('title', 'Manage Announcements')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0"><i class="bi bi-megaphone"></i> Manage Announcements</h2>
            <p class="text-muted mb-0">Create, view, and manage all system announcements</p>
        </div>
        <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create Announcement
        </a>
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
            <form method="GET" action="{{ route('admin.announcements.index') }}" class="needs-validation" novalidate>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Search Title</label>
                        <input type="text" name="search" class="form-control" 
                               placeholder="Enter announcement title..." 
                               value="{{ request('search') }}">
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-select">
                            <option value="">-- All Types --</option>
                            <option value="general" {{ request('type') === 'general' ? 'selected' : '' }}>General</option>
                            <option value="info" {{ request('type') === 'info' ? 'selected' : '' }}>Information</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex gap-2 align-items-end">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-search"></i> Search
                        </button>
                        <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Announcements Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-list-check"></i> All Announcements</h5>
            <small class="text-muted">{{ $announcements->total() }} announcements</small>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 30%">Title</th>
                            <th style="width: 15%">Type</th>
                            <th style="width: 30%">Content</th>
                            <th style="width: 12%">Created</th>
                            <th style="width: 8%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($announcements as $index => $announcement)
                        <tr>
                            <td>{{ $announcements->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $announcement->title }}</strong>
                            </td>
                            <td>
                                @if($announcement->type === 'info')
                                    <span class="badge bg-info">
                                        <i class="bi bi-info-circle"></i> Information
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-chat-dots"></i> General
                                    </span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ Str::limit($announcement->content, 50) }}</small>
                            </td>
                            <td>
                                <small class="text-muted">{{ $announcement->created_at->format('m/d/Y H:i') }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.announcements.show', $announcement->id) }}" 
                                       class="btn btn-outline-primary" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.announcements.edit', $announcement->id) }}" 
                                       class="btn btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal{{ $announcement->id }}" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal{{ $announcement->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-light border-danger">
                                        <h5 class="modal-title text-danger">
                                            <i class="bi bi-exclamation-triangle"></i> Confirm Delete
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-body">
                                            <p class="text-muted">Are you sure you want to delete this announcement?</p>
                                            <p class="fw-bold">{{ $announcement->title }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="text-muted mt-3">No announcements found</p>
                                <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-plus-circle"></i> Create First Announcement
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($announcements->hasPages())
            <nav class="mt-4">
                {{ $announcements->links() }}
            </nav>
            @endif
        </div>
    </div>
</div>
@endsection
