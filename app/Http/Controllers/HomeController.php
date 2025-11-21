<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Announcement;

class HomeController extends Controller
{
    /**
     * Homepage
     */
    public function index(Request $request)
    {
        $specialization = $request->query('specialization');
        $province = $request->query('province');

        // Featured lawyers (6 lawyers)
        $featuredLawyers = User::where('role', 'lawyer')
            ->where('status', 'active')
            ->where('is_verified', true)
            ->with(['lawyerProfile', 'ratings'])
            ->latest()
            ->take(6)
            ->get();

        if ($featuredLawyers->count() < 6) {
            $needed = 6 - $featuredLawyers->count();
            $additionalLawyers = User::select('users.*')
                ->join('lawyer_profiles', 'lawyer_profiles.user_id', '=', 'users.id')
                ->where('users.role', 'lawyer')
                ->where('users.status', 'active')
                ->where('users.is_verified', true)
                ->whereNotIn('users.id', $featuredLawyers->pluck('id'))
                ->with(['lawyerProfile', 'ratings'])
                ->orderByDesc('lawyer_profiles.experience')
                ->take($needed)
                ->get();
            $featuredLawyers = $featuredLawyers->merge($additionalLawyers);
        }

        // Search lawyers (if query exists)
        $searchResults = null;
        if ($specialization || $province) {
            $searchResults = User::where('role', 'lawyer')
                ->where('status', 'active')
                ->with(['lawyerProfile', 'ratings'])
                ->when($specialization, function ($q) use ($specialization) {
                    $q->whereHas('lawyerProfile', fn($q2) => 
                        $q2->where('specialization', $specialization)
                    );
                })
                ->when($province, function ($q) use ($province) {
                    $q->whereHas('lawyerProfile', fn($q2) => 
                        $q2->where('province', $province)
                    );
                })
                ->get();
        }

        // Announcements
        $announcements = Announcement::latest()->take(5)->get();

        // Dropdown values
        $allLawyers = User::where('role', 'lawyer')
            ->where('status', 'active')
            ->with('lawyerProfile')
            ->get();

        $specializations = $allLawyers->pluck('lawyerProfile.specialization')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $provinces = $allLawyers->pluck('lawyerProfile.province')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return view('home', compact(
            'featuredLawyers',
            'announcements',
            'specializations',
            'provinces',
            'searchResults',
            'specialization',
            'province'
        ));
    }
}
