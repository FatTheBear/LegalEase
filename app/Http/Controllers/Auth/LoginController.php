<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            
            // Update last login time
            $user->update(['last_login_at' => now()]);
            
            // If remember me is checked, save email to cookie for 7 days
            if ($remember) {
                \Cookie::queue('remember_email', $user->email, 60 * 24 * 7); // 7 days
            }
            
            // Admin không cần verify email
            if ($user->role !== 'admin') {
                // Check if email is verified
                if (!$user->hasVerifiedEmail()) {
                    Auth::logout();
                    throw ValidationException::withMessages([
                        'email' => ['Please verify your email before logging in. Check your inbox for the verification link.'],
                    ]);
                }
            }
            
            // Check user status for lawyers
            if ($user->role === 'lawyer' && $user->status !== 'active') {
                Auth::logout();
                
                if ($user->status === 'pending') {
                    throw ValidationException::withMessages([
                        'email' => ['Your lawyer account is pending approval. Please wait for admin review.'],
                    ]);
                } elseif ($user->status === 'rejected') {
                    throw ValidationException::withMessages([
                        'email' => ['Your lawyer account has been rejected. Please contact support.'],
                    ]);
                }
            }

            $request->session()->regenerate();

            // Redirect based on role
            return $this->redirectBasedOnRole($user);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    /**
     * Redirect user based on their role
     */
    private function redirectBasedOnRole($user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'lawyer':
                return redirect()->route('lawyer.dashboard');
            case 'customer':
                return redirect()->route('home');
            default:
                return redirect()->route('home');
        }
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
