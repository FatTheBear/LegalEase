<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DocumentUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Show registration choice form
     */
    public function showChoiceForm()
    {
        return view('auth.register-choice');
    }

    /**
     * Show customer registration form
     */
    public function showCustomerRegistrationForm()
    {
        return view('auth.register-customer');
    }

    /**
     * Show lawyer registration form
     */
    public function showLawyerRegistrationForm()
    {
        return view('auth.register-lawyer');
    }

    /**
     * Handle customer registration
     */
    public function registerCustomer(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'date_of_birth' => 'required|date|before:today',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Combine first_name and last_name for the name field
        $fullName = $request->first_name . ' ' . $request->last_name;

        $user = User::create([
            'name' => $fullName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
            'status' => 'active', // Customer can use immediately
        ]);

        // Create customer profile with personal information
        $user->customerProfile()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
        ]);

        // Send email verification notification
        $user->notify(new \App\Notifications\VerifyEmailNotification());

        return redirect()->route('login')
            ->with('success', 'Registration successful! Please check your email to verify your account before logging in.');
    }

    /**
     * Handle lawyer registration
     */
    public function registerLawyer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'specialization' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'workplace' => 'required|string|max:255',
            'license_number' => 'required|string|max:255',
            'documents' => 'required|array|min:1|max:3',
            'documents.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Max 2MB per file
        ], [
            'documents.required' => 'Please upload at least one certificate.',
            'documents.min' => 'Please upload at least one certificate.',
            'documents.max' => 'You can upload a maximum of 3 certificates.',
            'documents.*.mimes' => 'Each certificate must be a PDF, JPG, JPEG, or PNG file.',
            'documents.*.max' => 'Each certificate must not exceed 2MB.',
        ]);

        // Create user with pending status
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'lawyer',
            'status' => 'pending', // Needs admin approval
        ]);

        // Store lawyer profile information
        $user->lawyerProfile()->create([
            'specialization' => $request->specialization,
            'experience_years' => $request->experience_years,
            'workplace' => $request->workplace,
            'license_number' => $request->license_number,
        ]);

        // Handle document uploads
        foreach ($request->file('documents') as $index => $file) {
    $extension = $file->getClientOriginalExtension() ?: $file->extension();
    $fileSize = $file->getSize(); // bytes

    $originalBase = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    $safeBase = \Illuminate\Support\Str::slug($originalBase) ?: 'file';
    $fileName = time() . '_' . $index . '_' . $safeBase . '.' . $extension;

    $filePath = $file->storeAs('lawyer_documents', $fileName, 'public');

    DocumentUpload::create([
        'user_id' => $user->id,
        'file_name' => $fileName,
        'file_path' => $filePath,
        'file_extension' => $extension,
        'file_size' => $fileSize,
        'document_type' => 'certificate',
    ]);
}

        return redirect()->route('login')
            ->with('success', 'Lawyer registration submitted successfully! Your account is pending admin approval. You will receive an email once approved.');
    }
}