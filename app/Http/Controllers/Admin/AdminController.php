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
use App\Models\Rating;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Log when admin dashboard is accessed
        \Log::info('Admin Dashboard accessed by: ' . auth()->user()->email);
        
        $totalUsers = User::count();
        $totalLawyers = User::where('role', 'lawyer')->count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $totalAppointments = Appointment::count();
        $totalRatings = Rating::count();
        $recentLawyers = User::where('role', 'lawyer')->latest()->take(5)->get();
        $recentAppointments = Appointment::with(['client', 'lawyer'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalLawyers',
            'pendingAppointments',
            'totalAppointments',
            'totalRatings',
            'recentLawyers',
            'recentAppointments'
        ));
    }

    public function manageUsers()
    {
        $users = User::with('customerProfile')->get();
        return view('admin.users', compact('users'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function manageLawyers(Request $request)
    {
        $query = User::where('role', 'lawyer')->with('lawyerProfile');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by approval status
        if ($request->filled('approval_status')) {
            $query->where('approval_status', $request->approval_status);
        }

        // Filter by specialization
        if ($request->filled('specialization')) {
            $query->whereHas('lawyerProfile', function($q) use ($request) {
                $q->where('specialization', $request->specialization);
            });
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if ($sortBy === 'name') {
            $query->orderBy('name', $sortOrder);
        } elseif ($sortBy === 'last_login') {
            $query->orderBy('last_login_at', $sortOrder);
        } else {
            $query->orderBy('created_at', $sortOrder);
        }

        $lawyers = $query->paginate(10);
        return view('admin.lawyers', compact('lawyers'));
    }

    public function showLawyerProfile($id)
    {
        $lawyer = User::where('role', 'lawyer')
            ->with('lawyerProfile', 'documents')
            ->findOrFail($id);
        return view('admin.lawyers.show', compact('lawyer'));
    }

    public function approveLawyer($id)
    {
        $user = User::findOrFail($id);
        if ($user->role !== 'lawyer') {
            return redirect()->route('admin.lawyers.index')->with('error', 'Not a lawyer.');
        }
        
        // Update approval status
        $user->update(['approval_status' => 'approved']);
        
        // Send approval email
        \Mail::to($user->email)->send(new \App\Mail\LawyerApproved($user));
        
        return redirect()->route('admin.lawyers.index')->with('success', 'Lawyer approved successfully and notification email sent.');
    }

    public function rejectLawyer($id)
    {
        $user = User::findOrFail($id);
        if ($user->role !== 'lawyer') {
            return redirect()->route('admin.lawyers.index')->with('error', 'Not a lawyer.');
        }
        $user->update(['approval_status' => 'rejected']);
        return redirect()->route('admin.lawyers.index')->with('success', 'Lawyer rejected.');
    }

    public function updateLawyer(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->role !== 'lawyer') {
            return redirect()->route('admin.lawyers')->with('error', 'Not a lawyer.');
        }
        $user->update(['status' => $request->status]);
        return redirect()->route('admin.lawyers');
    }

    public function updateLawyerStatus(Request $request, $id)
    {
        $lawyer = User::findOrFail($id);
        
        if ($lawyer->role !== 'lawyer') {
            return redirect()->route('admin.lawyers.show', $id)->with('error', 'Not a lawyer.');
        }

        $request->validate([
            'status' => 'required|in:active,banned,inactive',
            'ban_reason_id' => 'required_if:status,banned|exists:ban_reasons,id'
        ]);

        // Cập nhật status
        $lawyer->update([
            'status' => $request->status,
            'ban_reason_id' => $request->status === 'banned' ? $request->ban_reason_id : null
        ]);
        
        // Gửi email nếu bị ban
        if ($request->status === 'banned' && $request->ban_reason_id) {
            $banReason = \App\Models\BanReason::find($request->ban_reason_id);
            \Mail::to($lawyer->email)->send(new \App\Mail\LawyerBanned($lawyer, $banReason));
        }
        
        $statusLabels = [
            'active' => 'activated',
            'banned' => 'banned',
            'inactive' => 'deactivated'
        ];

        return redirect()->route('admin.lawyers.show', $id)
            ->with('success', "Lawyer has been {$statusLabels[$request->status]} successfully.");
    }

    public function deleteLawyer($id)
    {
        $lawyer = User::findOrFail($id);
        
        if ($lawyer->role !== 'lawyer') {
            return redirect()->route('admin.lawyers.index')->with('error', 'Not a lawyer.');
        }

        $lawyerName = $lawyer->name;
        $lawyer->delete();

        return redirect()->route('admin.lawyers.index')
            ->with('success', "Lawyer '{$lawyerName}' and all associated data have been deleted successfully.");
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
            'type' => 'nullable|string|in:general,info',
        ]);
        Announcement::create($request->only('title', 'content', 'type'));
        return redirect()->route('admin.announcements')->with('success', 'Announcement created successfully.');
    }

    public function updateAnnouncement(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'nullable|string|in:general,info',
        ]);
        
        $announcement = Announcement::findOrFail($id);
        $announcement->update($request->only('title', 'content', 'type'));
        return redirect()->route('admin.announcements')->with('success', 'Announcement updated successfully.');
    }

    public function deleteAnnouncement($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();
        return redirect()->route('admin.announcements')->with('success', 'Announcement deleted successfully.');
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
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ added successfully.');
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
        return redirect()->route('admin.news.index')->with('success', 'News article added successfully.');
    }

    public function manageRatings()
    {
        $ratings = Rating::with(['client', 'lawyer'])->latest()->paginate(10);
        return view('admin.ratings.index', compact('ratings'));
    }

    public function editRating($id)
    {
        $rating = Rating::findOrFail($id);
        return view('admin.ratings.edit', compact('rating'));
    }

    public function updateRating(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|numeric|min:0.5|max:5',
            'comment' => 'nullable|string|max:500'
        ]);

        $rating = Rating::findOrFail($id);
        $rating->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('admin.ratings.index')->with('success', 'Rating updated successfully.');
    }

    public function deleteRating($id)
    {
        $rating = Rating::findOrFail($id);
        $rating->delete();
        return redirect()->route('admin.ratings.index')->with('success', 'Rating deleted successfully.');
    }
}