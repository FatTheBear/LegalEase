<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of all users with status filtering
     */
    public function index(Request $request)
    {
        $query = User::query();
        
        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }
        
        // Filter by registration date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Sort
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $users = $query->paginate(15);
        
        // Get statistics
        $stats = [
            'total' => User::count(),
            'active' => User::where('status', 'active')->count(),
            'inactive' => User::where('status', 'inactive')->count(),
            'banned' => User::where('status', 'banned')->count(),
            'pending' => User::where('status', 'pending')->count(),
            'new_this_week' => User::where('created_at', '>=', now()->subWeek())->count(),
        ];
        
        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent editing admin users
        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index')
                           ->with('error', 'Cannot edit admin users!');
        }
        
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Prevent updating admin users
        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index')
                           ->with('error', 'Cannot update admin users!');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'status' => 'required|in:active,inactive,pending,banned',
        ]);
        
        $user->update($validated);
        
        return redirect()->route('admin.users.index')
                       ->with('success', 'User updated successfully!');
    }

    /**
     * Change user status to active
     */
    public function activate($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent activating admin users
        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index')
                           ->with('error', 'Cannot modify admin users!');
        }
        
        $user->update(['status' => 'active']);
        
        return redirect()->route('admin.users.index')
                       ->with('success', 'User activated successfully!');
    }

    /**
     * Change user status to inactive
     */
    public function deactivate($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deactivating admin users
        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index')
                           ->with('error', 'Cannot modify admin users!');
        }
        
        $user->update(['status' => 'inactive']);
        
        return redirect()->route('admin.users.index')
                       ->with('success', 'User deactivated successfully!');
    }

    /**
     * Change user status to banned
     */
    public function ban($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent banning admin users
        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index')
                           ->with('error', 'Cannot ban admin users!');
        }
        
        $user->update(['status' => 'banned']);
        
        return redirect()->route('admin.users.index')
                       ->with('success', 'User banned successfully!');
    }

    /**
     * Get statistics about users
     */
    public function getStatistics()
    {
        return [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'inactive_users' => User::where('status', 'inactive')->count(),
            'banned_users' => User::where('status', 'banned')->count(),
            'pending_users' => User::where('status', 'pending')->count(),
            'customers' => User::where('role', 'customer')->count(),
            'lawyers' => User::where('role', 'lawyer')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'new_this_week' => User::where('created_at', '>=', now()->subWeek())->count(),
            'new_this_month' => User::where('created_at', '>=', now()->subMonth())->count(),
        ];
    }
}
