@extends('layouts.app')
@section('title', 'Edit Rating')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="bi bi-star"></i> Edit Rating</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.ratings.update', $rating->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="appointment" class="form-label">Appointment</label>
                    <input type="text" class="form-control" id="appointment" 
                           value="{{ $rating->appointment->id ?? 'N/A' }} - {{ $rating->appointment->client->name ?? 'N/A' }}" 
                           disabled>
                </div>

                <div class="mb-3">
                    <label for="lawyer" class="form-label">Lawyer</label>
                    <input type="text" class="form-control" id="lawyer" value="{{ $rating->lawyer->name ?? 'N/A' }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="rating" class="form-label">Rating (1-5)</label>
                    <input type="number" name="rating" id="rating" class="form-control" 
                           min="1" max="5" step="0.1" value="{{ old('rating', $rating->rating) }}" required>
                    @error('rating')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="comment" class="form-label">Comment</label>
                    <textarea name="comment" id="comment" class="form-control" rows="4">{{ old('comment', $rating->comment) }}</textarea>
                    @error('comment')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Rating</button>
                <a href="{{ route('admin.ratings.index') }}" class="btn btn-secondary">Cancel</a>
            </form>

            <form action="{{ route('admin.ratings.destroy', $rating->id) }}" method="POST" class="mt-3" onsubmit="return confirm('Are you sure you want to delete this rating?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Rating</button>
            </form>
        </div>
    </div>
</div>
@endsection
