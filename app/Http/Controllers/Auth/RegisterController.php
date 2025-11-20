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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
            'status' => 'active', // Customer can use immediately
        ]);

        // Auto login after registration
        auth()->login($user);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Customer registration successful! Welcome to LegalEase.');
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
            'documents.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Max 2MB per file
        ], [
            'documents.*.required' => 'Please upload at least one document.',
            'documents.*.mimes' => 'Documents must be PDF, JPG, JPEG, or PNG files.',
            'documents.*.max' => 'Each document must not exceed 2MB.',
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