@extends('layouts.app')
@section('title', 'Manage Schedule')

@section('content')
<div class="container mt-4">
    <h2>Manage Your Availability</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('lawyer.schedule') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-5">
                    <label>Date</label>
                    <input type="date" name="date" class="form-control" min="{{ today()->format('Y-m-d') }}" required>
                </div>
                <div class="col-md-4">
                    <label>Start Time</label>
                    <input type="time" name="start_time" class="form-control" required>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100">Add 2-Hour Slot</button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-4">
        <h4>Your Schedule (Future)</h4>
        @foreach($slots->groupBy('date') as $date => $daySlots)
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    {{ Carbon\Carbon::parse($date)->format('l, F j, Y') }}
                </div>
                <div class="card-body">
                    @foreach($daySlots as $slot)
                        <span class="badge bg-{{ $slot->is_booked ? 'danger' : 'success' }} me-2">
                            {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}

                            @if(!$slot->is_booked)
                                <form action="{{ route('lawyer.schedule.destroy', $slot->id) }}" 
                                    method="POST" 
                                    class="d-inline"
                                    onsubmit="return confirm('Xóa slot này?')">
                                    @csrf
                                    @method('DELETE') {{-- FIX QUAN TRỌNG --}}
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Xóa
                                    </button>
                                </form>
                            @endif

                        </span>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
