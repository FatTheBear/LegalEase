<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CustomerProfile;
use App\Models\LawyerProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    // Hiển thị trang chọn loại đăng ký
    public function showChoiceForm()
    {
        return view('auth.register-choice');
    }

    // Hiển thị form đăng ký Customer
    public function showCustomerForm()
    {
        return view('auth.register-customer');
    }

    // Hiển thị form đăng ký Lawyer
    public function showLawyerForm()
    {
        return view('auth.register-lawyer');
    }

    // Xử lý đăng ký Customer
    public function registerCustomer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        // Tạo user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
            'status' => 'active',
            // Xóa dòng này để email chưa verified
        ]);

        // Tạo customer profile
        CustomerProfile::create([
            'user_id' => $user->id,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // Gửi email xác thực
        event(new Registered($user));

        return redirect()->route('login')->with('success', 'Registration successful! Please check your email to verify your account.');
    }

    // Xử lý đăng ký Lawyer
    public function registerLawyer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'specialization' => 'required|string|max:50',
            'experience' => 'nullable|integer|min:0',
            'license_number' => 'required|string|max:100',
            'certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
            'city' => 'nullable|string|max:50',
            'province' => 'nullable|string|max:50',
            'bio' => 'nullable|string',
        ]);

        // Upload certificate
        $certificatePath = null;
        if ($request->hasFile('certificate')) {
            $certificatePath = $request->file('certificate')->store('certificates', 'public');
        }

        // Tạo user với status pending
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'lawyer',
            'status' => 'inactive', // Chưa active cho đến khi admin duyệt
            'approval_status' => 'pending', // Chờ admin duyệt
        ]);

        // Tạo lawyer profile
        LawyerProfile::create([
            'user_id' => $user->id,
            'specialization' => $request->specialization,
            'experience' => $request->experience,
            'license_number' => $request->license_number,
            'certificate_path' => $certificatePath,
            'city' => $request->city,
            'province' => $request->province,
            'bio' => $request->bio,
            'approval_status' => 'pending', // Chờ admin duyệt
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Your account is pending admin approval.');
    }
}

