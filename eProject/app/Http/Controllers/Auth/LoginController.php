<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Kiểm tra role và điều kiện đăng nhập
            if ($user->role === 'lawyer') {
                // Lawyer phải được admin approve mới login được
                if ($user->approval_status !== 'approved') {
                    Auth::logout();
                    return back()->with('error', 'Your account has not been approved by admin yet. Please wait!');
                }
            } elseif ($user->role === 'customer') {
                // Customer phải xác thực email mới login được
                if (is_null($user->email_verified_at)) {
                    Auth::logout();
                    return back()->with('error', 'Please verify your email before logging in!');
                }
            }

            // Redirect theo role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'lawyer':
                    return redirect()->route('lawyer.dashboard');
                case 'customer':
                    return redirect()->route('customer.dashboard');
                default:
                    return redirect('/');
            }
        }

        return back()->with('error', 'Email or password is incorrect!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
