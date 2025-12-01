<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Faq;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $faqs = Faq::all();
        return view('customer.dashboard', compact('faqs'));
    }
}
