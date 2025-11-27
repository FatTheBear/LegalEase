@extends('layouts.app')

@section('content')
<div class="container">
    <h2>- Schedule an appointment with lawyer #{{ $lawyer_id }}</h2>

    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf

        <input type="hidden" name="lawyer_id" value="{{ $lawyer_id }}">

        <div class="mb-3">
            <label>Appointment Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Select Time</label>
            <select name="time" class="form-control" required>
                <option value="">-- Select Time --</option>
                @foreach ($slots as $slot)
                    <option value="{{ $slot->time }}">{{ $slot->time }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">Book Appointment</button>
    </form>
</div>
@endsection
