<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        
        if(Auth::attempt($data)){
            $user = Auth::user();
            
            // Kiểm tra email đã được verify chưa (chỉ với user có verify_token)
            if ($user->verify_token && is_null($user->email_verified_at)) {
                Auth::logout(); // Logout ngay lập tức
                return back()->withErrors(['error' => 'Vui lòng xác thực email trước khi đăng nhập. Kiểm tra hộp thư của bạn.']);
            }
            
            $request->session()->regenerate();
            
            // Chuyển hướng theo role
            if($user->role === 'admin'){
                return redirect('/admin');
            } else {
                return redirect('/user');
            }
        }
        
        return back()->withErrors(['error' => 'Login failed! Invalid credentials.']);
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out successfully!');
    }
    
    public function showRegister()
    {
        return view('auth.register');
    }
    
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3|confirmed',
        ]);
        
        $data['password'] = bcrypt($data['password']);
        $data['verify_token'] = \Str::random(64); // Tạo token verify
        $user = \App\Models\User::create($data);
        
        // Gửi email xác nhận
        \Mail::to($user->email)->send(new \App\Mail\VerifyAccountMail($user));
        
        return view('auth.check-email')->with('email', $user->email);
    }
    
    public function verifyEmail($token)
    {
        $user = \App\Models\User::where('verify_token', $token)->first();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Invalid verification token.');
        }
        
        $user->email_verified_at = now();
        $user->verify_token = null; // Xóa token sau khi verify
        $user->save();
        
        return redirect()->route('login')->with('success', 'Email verified successfully! You can now login.');
    }
}
