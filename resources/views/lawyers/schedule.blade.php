@extends('layouts.app')
@section('title', 'Manage Schedule')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Manage Your Availability</h2>

    <div class="row">
        {{-- LEFT: CALENDAR --}}
        <div class="col-md-7">
            <div id="calendar"></div>
        </div>

        {{-- RIGHT: SLOT DETAILS --}}
        <div class="col-md-5">
            <div class="card">
                <div class="card-header btn-primary text-white d-flex justify-content-between align-items-center">
                    <h5 id="selected-date-title" class="mb-0">Select a date</h5>
                </div>

                {{-- Thêm giờ hành chính --}}
                <button id="addWorkHours" class="btn btn-secondary mt-2 mx-2">
                    Add Work Hours (4 slots)
                </button>

                <div class="card-body">
                    {{-- Xóa tất cả slot --}}
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6>Slots</h6>
                        <button id="delete-all-slots" class="btn btn-sm btn-primary">Delete All</button>
                    </div>

                    {{-- SLOT LIST --}}
                    <div id="slot-list">
                        <p class="text-muted">No date selected.</p>
                    </div>

                    {{-- FORM THÊM SLOT TÙY CHỌN --}}
                    <div id="slot-form" class="mt-3 d-none">
                        <h6>Add Time Slot</h6>
                        <form id="createSlotForm">
                            <input type="hidden" id="slot-date">

                            <div class="mb-2">
                                <label>Start Time</label>
                                <input type="time" class="form-control" id="start-time" required>
                            </div>

                            <div class="mb-2">
                                <label>End Time</label>
                                <input type="time" class="form-control" id="end-time" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-2">Add Slot</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- FULLCALENDAR --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,
        height: "auto",
        events: "{{ route('lawyer.schedule.json') }}",
        dateClick(info) {
            loadDaySlots(info.dateStr);
        },
        eventClick(info) {
            if (confirm("Delete this slot?")) {
                deleteSlot(info.event.id);
            }
        }
    });

    calendar.render();

    // -------------------------------
    // LOAD SLOTS OF SELECTED DATE
    // -------------------------------
    function loadDaySlots(date) {
        document.getElementById("selected-date-title").innerText = "Selected: " + date;
        document.getElementById("slot-date").value = date;
        document.getElementById("slot-form").classList.remove("d-none");

        fetch(`/lawyer/schedule/day/${date}`)
            .then(res => res.json())
            .then(data => {
                let list = "";
                if (data.length === 0) {
                    list = `<p class="text-muted">No slots yet.</p>`;
                } else {
                    data.forEach(slot => {
                        list += `
                            <div class="d-flex justify-content-between align-items-center border p-2 mb-2">
                                <span>${slot.start_time} - ${slot.end_time}</span>
                                <button class="btn btn-sm btn-secondary" onclick="deleteSlot(${slot.id})">X</button>
                            </div>`;
                    });
                }
                document.getElementById("slot-list").innerHTML = list;
            });
    }

    // -------------------------------
    // DELETE SLOT
    // -------------------------------
    window.deleteSlot = function(id) {
        fetch(`/lawyer/schedule/toggle/${id}`, {
            method: "DELETE",
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
        }).then(() => {
            calendar.refetchEvents();
            let date = document.getElementById("slot-date").value;
            if(date) loadDaySlots(date);
        });
    }

    // -------------------------------
    // ADD CUSTOM SLOT
    // -------------------------------
    document.getElementById("createSlotForm").addEventListener("submit", function(e) {
        e.preventDefault();

        fetch("{{ route('lawyer.schedule.store') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                date: document.getElementById("slot-date").value,
                start_time: document.getElementById("start-time").value,
                end_time: document.getElementById("end-time").value
            })
        }).then(() => {
            let date = document.getElementById("slot-date").value;
            calendar.refetchEvents();
            loadDaySlots(date);
        });
    });

    // -------------------------------
    // DELETE ALL SLOTS OF SELECTED DATE
    // -------------------------------
    document.getElementById("delete-all-slots").addEventListener("click", function () {
        let date = document.getElementById("slot-date").value;
        if (!date) return alert("Select a date first.");
        if (!confirm(`Delete all unbooked slots for ${date}?`)) return;

        fetch(`/lawyer/schedule/delete-day/${date}`, {
            method: "DELETE",
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
        }).then(() => {
            calendar.refetchEvents();
            loadDaySlots(date);
        });
    });

    // -------------------------------
    // ADD WORK HOURS (4 slot x 2h)
    // -------------------------------
    document.getElementById("addWorkHours").addEventListener("click", function () {
        let date = document.getElementById("slot-date").value;
        if (!date) return alert("Select a date first.");

        fetch("{{ route('lawyer.schedule.create-day') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ date }),
        })
        .then(res => res.json())
        .then(() => {
            alert("Added 4 work-hour slots!");
            calendar.refetchEvents();
            loadDaySlots(date);
        });
    });

});
</script>
@endsection
