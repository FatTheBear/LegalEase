<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Display admin landing page
     */
    public function index()
    {
        $faqs = Faq::all();
        
        return view('admin.landing', compact('faqs'));
    }
}
