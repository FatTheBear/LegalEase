<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Appointment;
use App\Models\Faq;
use App\Models\News;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalLawyers = User::where('role', 'lawyer')->count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $totalAppointments = Appointment::count();
        $recentLawyers = User::where('role', 'lawyer')->latest()->take(5)->get();
        $recentAppointments = Appointment::with(['client', 'lawyer'])->latest()->take(5)->get();
     
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalLawyers',
            'pendingAppointments',
            'totalAppointments',
            'recentLawyers',
            'recentAppointments'
       
        ));


    }

    public function manageUsers()
    {
        $users = User::with('customerProfile')->get();
        return view('admin.users.index', compact('users'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);
        return redirect()->route('admin.users.index')->with('success', 'Cập nhật người dùng thành công.');
    }

    public function manageLawyers()
    {
        $lawyers = User::where('role', 'lawyer')->with('lawyer')->get();
        return view('admin.lawyers.index', compact('lawyers'));
    }

    public function approveLawyer($id)
    {
        $user = User::findOrFail($id);
        if ($user->role !== 'lawyer') {
            return redirect()->route('admin.lawyers.index')->with('error', 'Không phải luật sư.');
        }
        $user->update(['status' => 'active']);
        return redirect()->route('admin.lawyers.index')->with('success', 'Duyệt luật sư thành công.');
    }

    public function updateLawyer(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->role !== 'lawyer') {
            return redirect()->route('admin.lawyers.index')->with('error', 'Không phải luật sư.');
        }
        $user->update(['status' => $request->status]);
        return redirect()->route('admin.lawyers.index')->with('success', 'Cập nhật trạng thái luật sư thành công.');
    }

    public function manageAppointments()
    {
        $appointments = Appointment::with(['client', 'lawyer'])->get();
        return view('admin.appointments.index', compact('appointments'));
    }

    public function updateAppointment(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => $request->status]);
        Notification::create([
            'user_id' => $appointment->client_id,
            'type' => 'appointment_status_updated',
            'content' => 'Lịch hẹn vào ' . $appointment->date . ' ' . $appointment->time . ' đã được cập nhật trạng thái thành ' . $request->status . '.',
        ]);
        Notification::create([
            'user_id' => $appointment->lawyer_id,
            'type' => 'appointment_status_updated',
            'content' => 'Lịch hẹn vào ' . $appointment->date . ' ' . $appointment->time . ' đã được cập nhật trạng thái thành ' . $request->status . '.',
        ]);
        return redirect()->route('admin.appointments.index')->with('success', 'Cập nhật trạng thái lịch hẹn thành công.');
    }

    public function manageAnnouncements()
    {
        $announcements = Announcement::latest()->get();
        return view('admin.announcements.index', compact('announcements'));
    }

    public function storeAnnouncement(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        Announcement::create($request->only('title', 'content'));
        return redirect()->route('admin.announcements.index')->with('success', 'Thêm thông báo thành công.');
    }

    public function manageFaqs()
    {
        $faqs = Faq::latest()->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function storeFaq(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);
        Faq::create($request->only('question', 'answer'));
        return redirect()->route('admin.faqs.index')->with('success', 'Thêm FAQ thành công.');
    }

    public function manageNews()
    {
        $news = News::latest()->get();
        return view('admin.news.index', compact('news'));
    }

    public function storeNews(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        News::create($request->only('title', 'content'));
        return redirect()->route('admin.news.index')->with('success', 'Thêm tin tức thành công.');
    }
}