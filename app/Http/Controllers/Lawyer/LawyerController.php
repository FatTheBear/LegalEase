<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LawyerController extends Controller
{
    public function index(Request $request)
    {
        $specialty = $request->query('specialty');
        $query = User::where('role', 'lawyer')->where('status', 'active')->with('lawyerProfile');

        if ($specialty) {
            $query->whereHas('lawyerProfile', function ($q) use ($specialty) {
                $q->where('specialty', 'like', '%' . $specialty . '%');
            });
        }

        $lawyers = $query->get();
        return view('lawyers.index', compact('lawyers'));
    }

    public function show($id)
    {
        $lawyer = User::where('role', 'lawyer')->where('status', 'active')->with('lawyerProfile')->findOrFail($id);
        return view('lawyers.show', compact('lawyer'));
    }

    public function dashboard()
    {
        $user = Auth::user();
        $appointments = Appointment::where('lawyer_id', $user->id)
            ->whereIn('status', ['pending', 'confirmed', 'completed'])
            ->with('client')
            ->latest()
            ->take(5)
            ->get();
        $notifications = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->latest()
            ->take(5)
            ->get();
        $totalAppointments = Appointment::where('lawyer_id', $user->id)->count();
        $pendingAppointments = Appointment::where('lawyer_id', $user->id)
            ->where('status', 'pending')
            ->count();
        $averageRating = $user->ratings()->avg('score') ?? null;

        return view('lawyers.dashboard', compact(
            'appointments',
            'notifications',
            'totalAppointments',
            'pendingAppointments',
            'averageRating'
        ));
    }
}