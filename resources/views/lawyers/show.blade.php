@extends('layouts.app')
@section('title', $lawyer->name . ' - Đặt lịch tư vấn')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4 text-center mb-4">
            <img src="{{ $lawyer->avatar ?? asset('images/default-lawyer.jpg') }}" 
                 class="rounded-circle shadow" width="150" height="150" alt="{{ $lawyer->name }}">
            <h3 class="mt-3">{{ $lawyer->name }}</h3>
            <p class="text-muted">
                <i class="bi bi-briefcase"></i> 
                {{ $lawyer->lawyerProfile->specialization ?? 'Luật sư đa ngành' }}
            </p>
            <p>
                <i class="bi bi-geo-alt"></i> 
                {{ $lawyer->lawyerProfile->province ?? 'Toàn quốc' }}
            </p>
        </div>

        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-calendar-check"></i> Chọn khung giờ tư vấn (2 tiếng/lượt)
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
                                <label class="form-label fw-bold">Chọn slot trống:</label>
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
                                                    <small class="text-muted d-block">Còn trống</small>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ghi chú (không bắt buộc)</label>
                                <textarea name="notes" class="form-control" rows="3" 
                                          placeholder="Ví dụ: Tôi cần tư vấn về hợp đồng lao động...">{{ old('notes') }}</textarea>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-success btn-lg px-5">
                                    <i class="bi bi-check-circle"></i> Xác nhận đặt lịch
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-calendar-x display-1 text-muted"></i>
                            <h5 class="mt-3 text-muted">Luật sư hiện chưa có lịch trống</h5>
                            <p>Vui lòng quay lại sau hoặc chọn luật sư khác.</p>
                            <a href="{{ route('lawyers.index') }}" class="btn btn-outline-primary">
                                Xem danh sách luật sư
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
    box-shadow: 0 4px 15px rgba(0,123,255,0.2) !important;
    border-color: #007bff !important;
}
</style>
@endsection