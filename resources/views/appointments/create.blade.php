@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Đặt lịch hẹn với luật sư #{{ $lawyer_id }}</h2>

    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf

        <input type="hidden" name="lawyer_id" value="{{ $lawyer_id }}">

        <div class="mb-3">
            <label>Ngày hẹn</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Chọn giờ</label>
            <select name="time" class="form-control" required>
                <option value="">-- Chọn giờ --</option>
                @foreach ($slots as $slot)
                    <option value="{{ $slot->time }}">{{ $slot->time }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Ghi chú</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">Đặt lịch</button>
    </form>
</div>
@endsection
