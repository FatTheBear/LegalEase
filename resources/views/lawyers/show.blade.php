@extends('layouts.app')
@section('title', $lawyer->name . ' - Book Consultation')

@section('content')
<div class="container mt-5">

    <!-- Flash Messages -->
    <div class="container mt-3">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="row justify-content-center">
        <!-- Thông tin luật sư -->
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

        <!-- Lịch và chọn slot -->
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-calendar-check"></i> Select Consultation Slot (2 hours/session)
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div id="calendar"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('appointments.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="lawyer_id" value="{{ $lawyer->id }}">
                                <div id="slot-list" class="mt-3">
                                    <p class="text-muted">No slots available for this day.</p>
                                </div>

                                <div class="mb-3 mt-2">
                                    <label class="form-label">Notes (optional)</label>
                                    <textarea name="notes" class="form-control" rows="3"
                                        placeholder="E.g.: I need advice on an employment contract..."></textarea>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary btn-lg px-5">
                                        <i class="bi bi-check-circle"></i> Confirm Booking
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- FullCalendar CSS & JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
{{-- css calendar --}}
{{-- tạo hiệu ứng hover  và active, các ngày khác nhau có khoảng cách nhẹ, bo góc mỗi ngày nhẹ với tone màu 3A4B41 nhạt hơn tùy chỉnh --}}
<style>
    /* Tùy chỉnh giao diện calendar */
    .fc .fc-daygrid-day {
        border: 1px solid #E6CFA7;
        border-radius: 8px;
        margin: 2px;
        transition: background-color 0.3s, transform 0.3s;
    }

    .fc .fc-daygrid-day:hover {
        background-color: rgba(58, 75, 65, 0.1);
        transform: translateY(-2px);
    }

    .fc .fc-daygrid-day.fc-day-today {
        background-color: rgba(58, 75, 65, 0.2);
        border: 2px solid #3A4B41;
    }

    .fc .fc-toolbar-title {
        color: #3A4B41 ;
        font-weight: 600;
    }

    .fc .fc-button {
        background-color: #E6CFA7;
        border: none;
        color: #3A4B41;
        font-weight: 600;
    }

    .fc .fc-button:hover {
        background-color: #d9c395;
        color: #3A4B41;
    }

    .fc .fc-button:focus {
        box-shadow: none;
    }

    .fc .fc-button:active {
        background-color: #E6CFA7;
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,
        height: "auto",
        dateClick(info) {
            // Lấy ngày theo múi giờ local: YYYY-MM-DD
            const localDate = info.date;
            const year = localDate.getFullYear();
            const month = String(localDate.getMonth() + 1).padStart(2, '0');
            const day = String(localDate.getDate()).padStart(2, '0');
            const date = `${year}-${month}-${day}`;
            
            fetchSlots(date);
        }
    });

    calendar.render();

    function fetchSlots(date) {
        fetch("{{ url('/lawyers/' . $lawyer->id . '/slots') }}/" + date)
            .then(res => res.json())
            .then(slots => {
                let list = '';
                if (slots.length === 0) {
                    list = '<p class="text-muted">No slots available for this day.</p>';
                } else {
                    slots.forEach(slot => {
                        list += `
                            <div class="form-check border rounded p-2 mb-2">
                                <input class="form-check-input" type="radio" name="slot_id" value="${slot.id}" id="slot${slot.id}" required>
                                <label class="form-check-label d-block" for="slot${slot.id}">
                                    <strong>${slot.date}</strong><br>
                                    ${slot.start_time} → ${slot.end_time}
                                </label>
                            </div>
                        `;
                    });
                }
                document.getElementById('slot-list').innerHTML = list;
            })
            .catch(err => {
                console.error(err);
                document.getElementById('slot-list').innerHTML = '<p class="text-danger">Error fetching slots.</p>';
            });
    }
});

// Auto-hide flash messages after 5 seconds
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(alert => {
        alert.classList.remove('show');
        alert.classList.add('hide');
    });
}, 5000);
</script>
@endsection
