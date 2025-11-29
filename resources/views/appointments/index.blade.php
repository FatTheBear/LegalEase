@extends('layouts.app')
@section('title', 'My Appointments')

@section('content')
<div class="container mt-5">
    {{-- ... (Phần nội dung chính của appointments) ... --}}
    
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold">
            {{ auth()->user()->role === 'lawyer' ? 'Client Appointments' : 'My Appointments' }}
        </h1>
        <p class="text-muted">
            {{ auth()->user()->role === 'lawyer' 
                ? 'Manage all consultation requests from clients' 
                : 'View and manage your booked legal consultations' 
            }}
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-lg border-0 text-center">
        <div class="card-header">
            <h3 class="mb-0">
                {{ auth()->user()->role === 'lawyer' ? 'Incoming Consultation Requests' : 'Your Booked Appointments' }}
            </h3>
            @if(auth()->user()->role === 'customer')
                <a href="{{ route('lawyers.index') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Book a New Consultation
                </a>
            @endif
        </div>

        <div class="card-body p-4">
            @if($appointments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>Date & Time</th>
                                @if(auth()->user()->role === 'lawyer')
                                    <th>Client</th>
                                    <th>Contact</th>
                                @else
                                    <th>Lawyer</th>
                                @endif
                                <th>Status</th>
                                <th>Notes</th>
                                <th>Actions</th>
                                <th>Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appt)
                                <tr class="{{ $appt->status === 'cancelled' ? 'table-danger' : '' }}">
                                    <td>
                                        <div class="fw-bold">
                                            {{ \Carbon\Carbon::parse($appt->appointment_time)->format('M d, Y') }}
                                        </div>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A') }}
                                            &rarr; {{ \Carbon\Carbon::parse($appt->end_time)->format('h:i A') }}
                                        </small>
                                    </td>

                                    @if(auth()->user()->role === 'lawyer')
                                        <td>
                                            <div class="fw-semibold">{{ $appt->client->name }}</div>
                                            <small class="text-muted">{{ $appt->client->email }}</small>
                                        </td>
                                        <td>
                                            <i class="bi bi-phone"></i> 
                                            {{ $appt->client->phone ?? 'Not provided' }}
                                        </td>
                                    @else
                                        <td>
                                            <a href="{{ route('lawyers.show', $appt->lawyer_id) }}" class="text-decoration-none">
                                                <div class="fw-semibold text-primary">{{ $appt->lawyer->name }}</div>
                                                <small>{{ $appt->lawyer->lawyerProfile?->specialization ?? 'General Practice' }}</small>
                                            </a>
                                        </td>
                                    @endif

                                    <td>
                                        @switch($appt->status)
                                            @case('pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                                @break
                                            @case('confirmed')
                                                <span class="badge bg-success">Confirmed</span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge bg-danger">Cancelled</span>
                                                @break
                                            @case('completed')
                                                <span class="badge bg-secondary">Completed</span>
                                                @break
                                        @endswitch
                                    </td>

                                    <td>
                                        <small class="text-muted">
                                            {{ Str::limit($appt->notes, 50) ?: '—' }}
                                        </small>
                                    </td>

                                    <td>
                                        @if($appt->status === 'pending')
                                            @if(auth()->user()->role === 'lawyer')
                                                <form action="{{ route('appointments.confirm', $appt->id) }}" method="POST" class="d-inline">
                                                    @csrf @method('PUT')
                                                    <button class="btn btn-sm btn-success">
                                                        <i class="bi bi-check-circle"></i> Confirm
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('appointments.cancel', $appt->id) }}" method="POST" class="d-inline ms-1">
                                                @csrf @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                        onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                                    <i class="bi bi-x-circle"></i> Cancel
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted small">No actions available</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($appt->status === 'completed' && auth()->user()->role === 'customer')
                                            @if(!$appt->rating)
                                                <button type="button" class="btn btn-sm btn-warning" 
                                                        data-bs-toggle="modal" data-bs-target="#ratingModal{{ $appt->id }}">
                                                    Rate Lawyer
                                                </button>
                                            @else
                                                <div class="text-success small">
                                                    Rated {{ $appt->rating->rating }} star{{ $appt->rating->rating > 1 ? 's' : '' }}
                                                    @if($appt->rating->comment)
                                                        <br><em>"{{ Str::limit($appt->rating->comment, 40) }}"</em>
                                                    @endif
                                                </div>
                                            @endif
                                        @elseif($appt->status === 'completed' && auth()->user()->role === 'lawyer' && $appt->rating)
                                            <div class="text-success small">
                                                Received {{ $appt->rating->rating }} star rating
                                            </div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                </tr>

                                @if($appt->status === 'completed' && auth()->user()->role === 'customer' && !$appt->rating)
                                    <div class="modal fade" id="ratingModal{{ $appt->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <form action="{{ route('ratings.store', $appt->id) }}" method="POST">
                                                @csrf

                                                <div class="modal-content border-0 shadow">
                                                    <div class="modal-header btn-primary">
                                                        <h5 class="modal-title text-white">
                                                            Rate Your Consultation with {{ $appt->lawyer->name }}
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body text-center py-5">
                                                        <div class="star-rating-wrapper mb-4">
                                                            <div class="star-rating">
                                                                {{-- Chuyển sang 5 sao (giá trị 1-5) --}}
                                                                @for($i = 5; $i >= 1; $i--)
                                                                    <input type="radio" name="rating" 
                                                                        id="star{{ $i }}-{{ $appt->id }}" value="{{ $i }}" required>
                                                                    <label for="star{{ $i }}-{{ $appt->id }}" title="{{ $i }} stars"></label>
                                                                @endfor
                                                            </div>
                                                            <p class="rating-feedback mt-3">How was your experience?</p>
                                                        </div>
                                                        <textarea name="comment" class="form-control feedback-textarea" rows="4" 
                                                                placeholder="Share your feedback (optional)"></textarea>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary px-5">Submit Rating</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-calendar-x display-1 text-muted"></i>
                    <h4 class="mt-4 text-muted">
                        {{ auth()->user()->role === 'lawyer' 
                            ? 'No appointments yet' 
                            : 'You have no booked appointments' 
                        }}
                    </h4>
                    <p class="text-muted">
                        {{ auth()->user()->role === 'lawyer' 
                            ? 'Clients will appear here once they book a consultation with you.' 
                            : 'Start by finding a lawyer and booking a consultation.' 
                        }}
                    </p>
                    @if(auth()->user()->role === 'customer')
                        <a href="{{ route('lawyers.index') }}" class="btn btn-primary btn-lg mt-3">
                            Find a Lawyer Now
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
  {{-- RATING HISTORY --}}
@if(isset($feedbacks) && $feedbacks->count() > 0)
<div class="container mt-5">
    <h4 class="mb-3 "><i class="bi bi-clock-history"></i> Rating History</h4>

    <div class="row g-3">
        @foreach($feedbacks as $fb)
        <div class="col-md-6">
            <div class="card shadow-sm p-3 d-flex align-items-center justify-content-between flex-row">

                {{-- Avatar --}}
                <div class="d-flex align-items-center">
                    <img src="{{ $fb->lawyer->avatar 
                        ? asset('storage/'.$fb->lawyer->avatar) 
                        : 'https://ui-avatars.com/api/?name=' . urlencode($fb->lawyer->name) . '&background=35563c&color=ffffff&size=80' }}"
                        class="rounded-circle me-3"
                        width="60" height="60">

                    <div>
                        <strong>{{ $fb->lawyer->name }}</strong><br>

                        {{-- ⭐ STAR DISPLAY FIXED (Sử dụng data-rating) --}}
                        <div class="rating-history-wrapper">
                            {{-- THAY ĐỔI: Sử dụng data-rating là giá trị rating thực tế --}}
                            <div class="rating-display" data-rating="{{ $fb->rating->rating }}"></div>
                            @if($fb->rating->comment)
                                <small class="text-muted"><em>"{{ Str::limit($fb->rating->comment, 40) }}"</em></small>
                            @endif
                        </div>
                        <small class="text-muted">{{ $fb->created_at->diffForHumans() }}</small>
                    </div>
                </div>

                {{-- View button --}}
                <button class="btn btn-primary btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#feedbackModal{{ $fb->id }}">
                    View
                </button>
            </div>
        </div>

        {{-- FEEDBACK DETAIL MODAL --}}
        <div class="modal fade" id="feedbackModal{{ $fb->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content text-center">

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Rating Details</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <br>
                        <p><strong>Lawyer:</strong> {{ $fb->lawyer->name }}</p>

                        <p><strong>Stars:</strong>
                            {{-- THAY ĐỔI: Sử dụng data-rating là giá trị rating thực tế --}}
                            <div class="rating-display-large" data-rating="{{ $fb->rating->rating }}"></div>
                        </p>

                        <p><strong>Comment:</strong><br>
                            {{ $fb->rating->comment ?? '— No comment provided —' }}
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif


</div>

<style>
/* Star rating 5 mức độ - Dành cho Modal Rate */
.modal{
    padding:20px;
}
.star-rating-wrapper {
    font-family: "Georgia", serif;
    padding: 10px;
}

.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: center;
    gap: 4px;
    font-size: 2.5rem;
}

.star-rating input[type="radio"] {
    display: none;
}

.star-rating label {
    cursor: pointer;
    /* Màu sao viền: Xanh đậm/nâu (để viền hiện rõ) */
    color: #3A4B41; 
    transition: color 0.2s, transform 0.2s;
    font-size: 2.5rem;
    line-height: 1; /* Quan trọng để sao viền hiển thị đúng */
}

.star-rating label::before {
    content: "☆"; /* Ngôi sao viền (Outline Star) */
}

/* Khi checked, hover, hoặc là các sao phía trước sao hover thì đổ đầy màu */
.star-rating input[type="radio"]:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #3A4B41; /* Màu xanh đậm/nâu khi active/hover */
    transform: scale(1.1);
}

/* Khi checked, hover, phải dùng sao đặc (★) để đổ đầy màu */
.star-rating input[type="radio"]:checked ~ label::before,
.star-rating label:hover::before,
.star-rating label:hover ~ label::before {
    content: "★"; /* Ngôi sao đặc (Filled Star) */
}


/* Feedback */
.rating-feedback {
    font-size: 1.1rem;
    color: #3A4B41;
    font-weight: 500;
}

.feedback-textarea {
    border-radius: 12px;
    border: 1px solid #3A4B41;
    padding: 12px;
    font-family: "Georgia", serif;
    color: #1E1E1E;
    background-color: #F9F6EF;
    resize: vertical;
    transition: border-color 0.25s, box-shadow 0.25s;
}

.feedback-textarea:focus {
    outline: none;
    border-color: #E6CFA7;
    box-shadow: 0 0 8px rgba(58, 75, 65, 0.3);
}

/* --- Custom CSS for Rating History (Vẫn dùng sao đặc để hiển thị rating) --- */

.rating-history-wrapper {
    line-height: 1.2;
    margin-bottom: 5px; 
}

/* BASE RATING DISPLAY (Sử dụng kỹ thuật sao kép) */
.rating-display, .rating-display-large {
    display: inline-block;
    font-size: 1rem; 
    line-height: 1;
    color: #3A4B41; /* Màu sao hiển thị trong history */
    position: relative;
}

/* Base stars (5 empty stars) - Dùng sao đặc màu xám để làm nền */
.rating-display::before, .rating-display-large::before {
    content: '★★★★★';
    letter-spacing: 1px; 
    color: #ccc; /* Màu xám cho sao nền */
}

/* Foreground stars (colored based on rating value) - Dùng sao đặc màu xanh để phủ lên */
.rating-display::after, .rating-display-large::after {
    content: '★★★★★';
    position: absolute;
    top: 0;
    left: 0;
    overflow: hidden;
    color: #3A4B41; 
    letter-spacing: 1px;
    white-space: nowrap; 
    
    /* Chú ý: width này sẽ được thiết lập chính xác bằng JavaScript */
    width: 0%; 
}

.rating-display-large {
    font-size: 1.4rem; 
}
.rating-display-large::before, .rating-display-large::after {
    letter-spacing: 2px;
}
</style>

{{-- KHỐI SCRIPT MỚI: Dùng JavaScript để tính toán width sao cho chính xác --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hàm áp dụng width cho các ngôi sao
    function updateStarWidths() {
        const ratingElements = document.querySelectorAll('.rating-display, .rating-display-large');
        
        ratingElements.forEach(element => {
            const rating = parseFloat(element.getAttribute('data-rating'));
            
            // Tính toán phần trăm chiều rộng (rating / 5 * 100)
            const widthPercentage = (rating / 5) * 100;
            
            // Tìm phần tử ::after (phần tử chứa sao màu) và áp dụng style width
            // Chúng ta không thể truy cập trực tiếp ::after, thay vào đó ta áp dụng 
            // style lên phần tử chính, và dùng CSS Variable hoặc JavaScript để set width.
            
            // Cách đơn giản nhất: set style trực tiếp lên element
            // Tuy nhiên, vì chúng ta đang dùng ::after, cách làm này không hoạt động trực tiếp.
            // Giải pháp: Tối ưu lại logic CSS một chút.
            
            // Cách tối ưu (Dựa vào style attribute cho phần tử chính):
            // Chúng ta sẽ set CSS Variable lên element, và CSS ::after sẽ dùng variable đó
            element.style.setProperty('--rating-width', widthPercentage + '%');
        });
    }

    updateStarWidths();
});
</script>

{{-- Cần cập nhật lại CSS ::after để sử dụng CSS Variable --}}
<style>
/* ... (Giữ nguyên các style khác) ... */

/* BASE RATING DISPLAY (Sử dụng kỹ thuật sao kép) */
.rating-display, .rating-display-large {
    /* Khai báo biến CSS mặc định */
    --rating-width: 0%; 
    display: inline-block;
    font-size: 1rem; 
    line-height: 1;
    color: #3A4B41; 
    position: relative;
}

/* ... (Base stars ::before giữ nguyên) ... */

/* Foreground stars (colored based on rating value) */
.rating-display::after, .rating-display-large::after {
    content: '★★★★★';
    position: absolute;
    top: 0;
    left: 0;
    overflow: hidden;
    color: #3A4B41; 
    letter-spacing: 1px;
    white-space: nowrap; 
    
    /* THAY ĐỔI QUAN TRỌNG: Sử dụng biến CSS được set bằng JavaScript */
    width: var(--rating-width); 
}

/* ... (Các style khác cho Large display giữ nguyên) ... */
</style>
@endsection