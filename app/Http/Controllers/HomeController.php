<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function index(){
        $lawyers = User::where('role', 'lawyer')
            ->where('status', 'active')
            ->with('lawyerProfile')
            ->latest()
            ->take(6)
            ->get();
            
        $news = collect(); // Empty collection for now

        return view('home', compact('lawyers', 'news'));
    }
}
