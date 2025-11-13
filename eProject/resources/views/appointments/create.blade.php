@extends('layouts.app')
@section('title', 'Đặt lịch tư vấn')

@section('content')
<h2>Đặt lịch hẹn</h2>
<form action="{{ route('appointments.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Chọn luật sư:</label>
        <select name="lawyer_id" class="form-control">
            @foreach($lawyers as $lawyer)
                <option value="{{ $lawyer->id }}">{{ $lawyer->user->name }} - {{ $lawyer->specialization }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Thời gian hẹn:</label>
        <input type="datetime-local" name="appointment_time" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Ghi chú:</label>
        <textarea name="note" class="form-control"></textarea>
    </div>
    <button class="btn btn-primary">Đặt lịch</button>
</form>
@endsection
