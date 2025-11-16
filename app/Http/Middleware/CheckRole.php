<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $role
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Kiểm tra role
        if ($user->role !== $role) {
            // Redirect về dashboard phù hợp với role của user
            return $this->redirectToDashboard($user->role);
        }

        // Kiểm tra thêm điều kiện cho lawyer và customer
        if ($user->role === 'lawyer' && $user->approval_status !== 'approved') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account has not been approved yet.');
        }

        if ($user->role === 'customer' && is_null($user->email_verified_at)) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Please verify your email first.');
        }

        return $next($request);
    }

    /**
     * Redirect to appropriate dashboard based on role
     */
    private function redirectToDashboard($role)
    {
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'lawyer':
                return redirect()->route('lawyer.dashboard');
            case 'customer':
                return redirect()->route('customer.dashboard');
            default:
                return redirect()->route('home');
        }
    }
}

