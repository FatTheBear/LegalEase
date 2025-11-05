<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['lawyer', 'customer'])->get();
        return view('admin.appointments', compact('appointments'));
    }
}
