@extends('layouts.app')
@section('title', 'Manage Lawyer Schedules')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Manage Lawyer Schedules</h2>
    
    <div class="row mb-3">
        <div class="col-md-6 mb-2">
            <input type="text" id="searchLawyer" class="form-control" placeholder="Search lawyer by name...">
        </div>
    </div>


        {{-- LAWYER CARDS --}}
    <div class="row mb-4" id="lawyerCards">
        @foreach($lawyers as $lawyer)
            <div class="col-md-2 col-6 mb-3">
                <div class="card lawyer-card text-center h-100 cursor-pointer" 
                     data-lawyer-id="{{ $lawyer->id }}">
                    @php
                        $avatarUrl = $lawyer->hasAvatar() 
                            ? $lawyer->getAvatarUrl() 
                            : 'https://ui-avatars.com/api/?name=' . urlencode($lawyer->name) . '&background=35563c&color=ffffff&size=150';
                    @endphp
                    <img src="{{ $avatarUrl }}" class="card-img-top rounded-circle mx-auto mt-2" style="width:70px; height:70px;" alt="{{ $lawyer->name }}">
                    <div class="card-body p-2">
                        <h6 class="card-title mb-1">{{ $lawyer->name }}</h6>
                        <p class="text-muted small mb-1">{{ $lawyer->lawyerProfile->specialization ?? 'N/A' }}</p>
                        <button class="btn btn-sm btn-primary view-dates-btn" data-lawyer-id="{{ $lawyer->id }}">View Dates</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- LAWYER PAGINATION --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $lawyers->links( 'pagination::bootstrap-5') }}
    </div>

    {{-- SELECTED LAWYER DATES --}}
    <div id="lawyerDates" class="mb-4"></div>

    {{-- SELECTED DATE SLOTS --}}
    <div id="dateSlots" class="mb-4"></div>

    <hr>

    {{-- UPCOMING SLOTS --}}
    <div id="allUpcomingSlots">
        <h4>Upcoming Slots (All Lawyers)</h4>
        @if($slots->count() > 0)
            <ul class="list-group">
                @foreach($slots as $slot)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $slot->lawyer->name }}</strong> ({{ $slot->lawyer->lawyerProfile->specialization ?? 'N/A' }})<br>
                            {{ \Carbon\Carbon::parse($slot->date)->format('d/m/Y') }} 
                            {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} 
                            → {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                        </div>
                        <button class="btn btn-sm btn-primary" onclick="deleteSlot({{ $slot->id }})">Delete</button>
                    </li>
                @endforeach
            </ul>

            {{-- UPCOMING SLOTS PAGINATION --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $slots->links( 'pagination::bootstrap-5') }}
            </div>
        @else
            <p class="text-muted">No upcoming slots.</p>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const lawyerCards = document.querySelectorAll('.view-dates-btn');
    const lawyerDates = document.getElementById('lawyerDates');
    const dateSlots = document.getElementById('dateSlots');

    lawyerCards.forEach(btn => {
        btn.addEventListener('click', function() {
            const lawyerId = this.dataset.lawyerId;
            fetch(`/admin/lawyer-schedules/lawyer/${lawyerId}`)
                .then(res => res.json())
                .then(dates => {
                    if(dates.length === 0){
                        lawyerDates.innerHTML = '<p class="text-muted">No available dates for this lawyer.</p>';
                        dateSlots.innerHTML = '';
                        return;
                    }
                    let html = '<h5>Available Dates</h5><div class="row">';
                    dates.forEach(dateObj => {
                        html += `<div class="col-md-2 col-6 mb-2">
                                    <div class="card text-center p-2 date-card cursor-pointer" 
                                         data-lawyer-id="${lawyerId}" 
                                         data-date="${dateObj.date}">
                                        ${dateObj.date_formatted}<br>
                                    </div>
                                 </div>`;
                    });
                    html += '</div>';
                    lawyerDates.innerHTML = html;
                    dateSlots.innerHTML = '';
                    addDateClickListeners();
                });
        });
    });

    function addDateClickListeners(){
        const dateCards = document.querySelectorAll('.date-card');
        dateCards.forEach(card => {
            card.addEventListener('click', function(){
                const lawyerId = this.dataset.lawyerId;
                const date = this.dataset.date;
                fetch(`/admin/lawyer-schedules/${lawyerId}/${date}/slots`)
                    .then(res => res.json())
                    .then(slots => {
                        if(slots.length === 0){
                            dateSlots.innerHTML = '<p class="text-muted">No slots for this date.</p>';
                            return;
                        }
                        let html = '<h5>Slots on '+slots[0].date_formatted+'</h5><ul class="list-group">';
                        slots.forEach(slot => {
                            html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                                        ${slot.start_time} → ${slot.end_time}
                                        <button class="btn btn-sm btn-primary" onclick="deleteSlot(${slot.id})">Delete</button>
                                     </li>`;
                        });
                        html += '</ul>';
                        dateSlots.innerHTML = html;
                    });
            });
        });
    }

    window.deleteSlot = function(id) {
        if(!confirm('Delete this slot?')) return;
        fetch(`/admin/lawyer-schedules/delete/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        }).then(() => location.reload());
    }
});
    document.addEventListener('DOMContentLoaded', function() {
        const lawyerCards = document.querySelectorAll('.lawyer-card');
        const searchInput = document.getElementById('searchLawyer');

        searchInput.addEventListener('input', function() {
            const searchText = this.value.toLowerCase();

            lawyerCards.forEach(card => {
                const name = card.querySelector('.card-title').textContent.toLowerCase();
                card.parentElement.style.display = name.includes(searchText) ? 'block' : 'none';
            });
        });
    });


</script>
@endsection
<style>
/* Hover effect cho thẻ luật sư */
.lawyer-card, .date-card {
    transition: transform 0.2s, box-shadow 0.2s;
}
.lawyer-card:hover, .date-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

/* Thẻ đang chọn */
.lawyer-card.selected , .date-card.selected {
    border: 2px solid #007bff;
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
}
</style>
