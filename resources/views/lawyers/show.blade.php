@extends('layouts.app')
@section('title', $lawyer->name . ' - Book Consultation')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4 text-center mb-4">
            @php
            $avatarUrl = $lawyer->avatar
                ? asset('storage/' . $lawyer->avatar)
                : 'https://ui-avatars.com/api/?name=' . urlencode($lawyer->name) . '&background=35563c&color=ffffff&size=150';
            @endphp

            <img src="{{ $avatarUrl }}" 
                class="rounded-circle shadow"
                width="150" height="150"
                alt="{{ $lawyer->name }}">

            <h3 class="mt-3">{{ $lawyer->name }}</h3>
            <p class="text-muted">
                <i class="bi bi-briefcase"></i> 
                {{ $lawyer->lawyerProfile->specialization ?? 'Multi-field Lawyer' }}
            </p>
            <p>
                <i class="bi bi-geo-alt"></i> 
                {{ $lawyer->lawyerProfile->province ?? 'Nationwide' }}
            </p>
        </div>

        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-calendar-check"></i> Select Consultation Slot (2 hours/session)
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($availableSlots->count() > 0)
                        <form action="{{ route('appointments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="lawyer_id" value="{{ $lawyer->id }}">

                            <div class="mb-4">
                                <label class="form-label fw-bold">Select Available Slot:</label>
                                <div class="row g-3">
                                    @foreach($availableSlots as $slot)
                                        <div class="col-md-6">
                                            <div class="form-check border rounded p-3 hover-shadow 
                                                {{ old('slot_id') == $slot->id ? 'border-primary bg-light' : '' }}">
                                                <input class="form-check-input" type="radio" 
                                                        name="slot_id" id="slot{{ $slot->id }}" 
                                                        value="{{ $slot->id }}" required>
                                                <label class="form-check-label d-block" for="slot{{ $slot->id }}">
                                                    <strong>
                                                        {{ \Carbon\Carbon::parse($slot->date)->format('d/m/Y (l)') }}
                                                    </strong><br>
                                                    <span class="text-success">
                                                        {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}
                                                        → {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                                                    </span>
                                                    <small class="text-muted d-block">Available</small>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Notes (optional)</label>
                                <textarea name="notes" class="form-control" rows="3" 
                                          placeholder="E.g.: I need advice on an employment contract...">{{ old('notes') }}</textarea>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary btn-lg px-5 ">
                                    <i class="bi bi-check-circle"></i> Confirm Booking
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-calendar-x display-1 text-muted"></i>
                            <h5 class="mt-3 text-muted">The lawyer currently has no available slots</h5>
                            <p>Please check back later or select a different lawyer.</p>
                            <a href="{{ route('lawyers.index') }}" class="btn btn-primary">
                                View Lawyer List
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.hover-shadow {
    transition: all 0.2s;
    cursor: pointer;
}
.hover-shadow:hover {
    box-shadow: 0 4px 15px rgba(11, 71, 30, 0.2) !important;
    border-color: #35563c !important;
}
</style>
@endsection