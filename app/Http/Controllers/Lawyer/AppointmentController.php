<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::all();
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        return view('appointments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'appointment_time' => 'required|date'
        ]);

        Appointment::create([
            'customer_id' => auth()->id(),
            'lawyer_id' => $request->lawyer_id,
            'appointment_time' => $request->appointment_time,
            'note' => $request->note,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Đặt lịch thành công!');
    }
}
