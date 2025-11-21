@extends('layouts.app')
@section('title', 'Lịch hẹn của tôi')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">
        {{ auth()->user()->role === 'lawyer' ? 'Lịch hẹn tư vấn' : 'Lịch hẹn của tôi' }}
    </h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                {{ auth()->user()->role === 'lawyer' ? 'Danh sách lịch hẹn từ khách hàng' : 'Các lịch hẹn đã đặt' }}
            </h5>
            @if(auth()->user()->role === 'customer')
                <a href="{{ route('lawyers.index') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-circle"></i> Đặt lịch mới
                </a>
            @endif
        </div>

        <div class="card-body">
            @if($appointments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Ngày giờ</th>
                                @if(auth()->user()->role === 'lawyer')
                                    <th>Khách hàng</th>
                                    <th>Số điện thoại</th>
                                @else
                                    <th>Luật sư</th>
                                @endif
                                <th>Trạng thái</th>
                                <th>Ghi chú</th>
                                <th>Hành động</th>
                                <th>Đánh giá</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appt)
                                <tr>
                                    <td>
                                        <strong>{{ \Carbon\Carbon::parse($appt->appointment_time)->format('d/m/Y') }}</strong><br>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($appt->appointment_time)->format('H:i') }}
                                            → {{ \Carbon\Carbon::parse($appt->end_time)->format('H:i') }}
                                        </small>
                                    </td>

                                    @if(auth()->user()->role === 'lawyer')
                                        <td>{{ $appt->client->name }}</td>
                                        <td>{{ $appt->client->phone ?? 'Chưa cung cấp' }}</td>
                                    @else
                                        <td>
                                            <a href="{{ route('lawyers.show', $appt->lawyer_id) }}">
                                                {{ $appt->lawyer->name }}
                                            </a>
                                        </td>
                                    @endif

                                    <td>
                                        @if($appt->status === 'pending')
                                            <span class="badge bg-warning">Chờ xác nhận</span>
                                        @elseif($appt->status === 'confirmed')
                                            <span class="badge bg-success">Đã xác nhận</span>
                                        @elseif($appt->status === 'cancelled')
                                            <span class="badge bg-danger">Đã hủy</span>
                                        @elseif($appt->status === 'completed')
                                            <span class="badge bg-secondary">Hoàn thành</span>
                                        @endif
                                    </td>

                                    <td>
                                        <small>{{ $appt->notes ?? 'Không có' }}</small>
                                    </td>

                                    <td>
                                        @if($appt->status === 'pending')
                                            @if(auth()->user()->role === 'lawyer')
                                                <form action="{{ route('appointments.confirm', $appt->id) }}" method="POST" class="d-inline">
                                                    @csrf @method('PUT')
                                                    <button class="btn btn-sm btn-success">Xác nhận</button>
                                                </form>
                                            @endif
                                            <form action="{{ route('appointments.cancel', $appt->id) }}" method="POST" class="d-inline">
                                                @csrf @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn muốn hủy lịch hẹn này?')">Hủy</button>
                                            </form>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($appt->status === 'completed' && auth()->user()->role === 'customer')
                                            @php
                                                $hasRated = \App\Models\Rating::where('lawyer_id', $appt->lawyer_id)
                                                                              ->where('client_id', auth()->id())
                                                                              ->where('appointment_id', $appt->id)
                                                                              ->exists();
                                            @endphp

                                            @if(!$hasRated)
                                                <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#ratingModal{{ $appt->id }}">
                                                    Đánh giá
                                                </button>

                                                <div class="modal fade" id="ratingModal{{ $appt->id }}" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <form action="{{ route('ratings.store') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="lawyer_id" value="{{ $appt->lawyer_id }}">
                                                            <input type="hidden" name="appointment_id" value="{{ $appt->id }}">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Đánh giá luật sư: {{ $appt->lawyer->name }}</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="text-center mb-3">
                                                                        <div class="star-rating">
                                                                            @for($i = 5; $i >= 1; $i--)
                                                                                <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}-{{ $appt->id }}" required>
                                                                                <label for="star{{ $i }}-{{ $appt->id }}" title="{{ $i }} sao"></label>
                                                                            @endfor
                                                                        </div>
                                                                    </div>
                                                                    <textarea name="comment" class="form-control" rows="3" placeholder="Nhận xét của bạn (không bắt buộc)"></textarea>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                                    <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-success small">Đã đánh giá</span>
                                            @endif
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-calendar-x" style="font-size: 4rem; color: #ccc;"></i>
                    <p class="text-muted mt-3">
                        {{ auth()->user()->role === 'lawyer' 
                            ? 'Chưa có khách hàng nào đặt lịch với bạn.' 
                            : 'Bạn chưa đặt lịch hẹn nào.' 
                        }}
                    </p>
                    @if(auth()->user()->role === 'customer')
                        <a href="{{ route('lawyers.index') }}" class="btn btn-primary">Tìm luật sư ngay</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: center;
}
.star-rating input[type="radio"] {
    display: none;
}
.star-rating label {
    font-size: 1.5rem;
    color: #ddd;
    cursor: pointer;
}
.star-rating input[type="radio"]:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #ffc107;
}
</style>
@endsection
