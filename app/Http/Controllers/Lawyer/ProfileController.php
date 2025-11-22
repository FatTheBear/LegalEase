<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $lawyer = Auth::user();
        return view('lawyers.profile.edit', compact('lawyer'));
    }

    public function update(Request $request)
    {
        $lawyer = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $lawyer->id,
            'password' => 'nullable|min:8|confirmed',
            'specialization' => 'required|string|max:255',
            'years_of_experience' => 'required|integer|min:0',
            'license_number' => 'required|string|max:100',
            'workplace' => 'required|string|max:255',
            'documents' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'specialization', 'years_of_experience', 'license_number', 'workplace']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('documents')) {
            $path = $request->file('documents')->store('lawyer-documents', 'public');
            $data['documents'] = $path;
        }

        $lawyer->update($data);

        return back()->with('success', 'Profile updated successfully!');
    }
}