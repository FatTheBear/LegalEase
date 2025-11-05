<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\User;

class LawyerController extends Controller
{
    public function index()
    {
        $lawyers = User::where('role', 'lawyer')->get();
        return view('lawyers.index', compact('lawyers'));
    }

    public function show($id)
    {
        $lawyer = User::findOrFail($id);
        return view('lawyers.show', compact('lawyer'));
    }

    public function dashboard()
    {
        return view('lawyers.dashboard');
    }
}
