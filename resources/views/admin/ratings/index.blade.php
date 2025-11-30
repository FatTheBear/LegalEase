@extends('layouts.app')
@section('title', 'Manage Ratings')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="bi bi-star"></i> Manage Ratings</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Lawyer</th>
                    <th>Client</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ratings as $index => $r)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $r->lawyer->name ?? 'N/A' }}</td>
                    <td>{{ $r->client->name ?? 'N/A' }}</td>
                    <td>
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= $r->rating ? '-fill' : '' }}"></i>
                        @endfor
                    </td>
                    <td>{{ $r->comment ?? '-' }}</td>
                    <td>{{ $r->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('admin.ratings.edit', $r->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('admin.ratings.destroy', $r->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No ratings found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $ratings->links() }}
</div>
@endsection
