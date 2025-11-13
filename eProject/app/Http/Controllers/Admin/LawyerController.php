<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class LawyerController extends Controller
{
    public function index()
    {
        $lawyers = User::where('role', 'lawyer')->get();
        return view('admin.lawyers', compact('lawyers'));
    }
}
