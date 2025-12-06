<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use App\Notifications\SendPasswordResetNotification;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user()->load('customerProfile');
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();

        // Combine first_name and last_name for the name field
        $fullName = $request->first_name . ' ' . $request->last_name;

        // Update user name and email
        $user->update([
            'name'  => $fullName,
            'email' => $request->email,
        ]);

        // Update or create customer profile with first_name and last_name
        if ($user->customerProfile) {
            $user->customerProfile->update([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
            ]);
        } else {
            $user->customerProfile()->create([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
            ]);
        }

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updateAvatar(Request $request)
    {
        try {
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $user = Auth::user();

            // Check if file exists
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');

                // Delete old avatar if exists
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }

                // Upload new avatar - lưu vào storage/app/public/avatars
                $path = $file->store('avatars', 'public');

                // Cập nhật vào model
                $user->avatar = $path;
                $user->save();

                // Return JSON response for AJAX requests
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Avatar updated successfully!',
                        'avatarUrl' => $user->getAvatarUrl()
                    ]);
                }

                return back()->with('success', 'Avatar updated successfully!');
            }

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No file uploaded.'
                ], 400);
            }

            return back()->withErrors(['avatar' => 'No file uploaded.']);
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error uploading avatar: ' . $e->getMessage()
                ], 500);
            }
            return back()->withErrors(['avatar' => 'Error uploading avatar: ' . $e->getMessage()]);
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password changed successfully!');
    }

    /**
     * Send password reset link to user's email
     */
    public function sendPasswordResetLink(Request $request)
    {
        $user = Auth::user();
        
        // Track reset attempts in session
        $resetAttemptsKey = 'password_reset_attempts_' . $user->id;
        $resetAttempts = session($resetAttemptsKey, 0);
        
        // Check if user has exceeded maximum attempts (3 times)
        if ($resetAttempts >= 3) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => true,
                    'message' => 'You have reached the maximum number of password reset attempts. Please try again later.',
                    'maxAttemptsReached' => true
                ], 429);
            }
            return back()->withErrors(['reset' => 'You have reached the maximum number of password reset attempts.']);
        }
        
        // Increment reset attempts
        $resetAttempts++;
        session([$resetAttemptsKey => $resetAttempts]);
        
        // Generate reset token
        $token = Str::random(64);

        // Store token in password_resets table
        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        // Send notification
        try {
            $user->notify(new SendPasswordResetNotification($token));
            
            // Log for debugging
            \Log::info('Password reset email sent', [
                'user_id' => $user->id,
                'email' => $user->email,
                'mail_driver' => config('mail.default')
            ]);
        } catch (\Exception $e) {
            // Log error
            \Log::error('Failed to send password reset email', [
                'user_id' => $user->id,
                'email' => $user->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Decrement attempts if email sending fails
            session([$resetAttemptsKey => $resetAttempts - 1]);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => true,
                    'message' => 'An error occurred while sending the email: ' . $e->getMessage() . '. Please check your mail configuration.'
                ], 500);
            }
            return back()->withErrors(['reset' => 'An error occurred while sending the email. Please check your mail configuration.']);
        }

        // Determine message based on attempts
        $remainingAttempts = 3 - $resetAttempts;
        $message = 'Password reset link has been sent to your email. Please check your inbox.';
        
        if ($remainingAttempts == 1) {
            $message .= ' You have 1 more password reset attempt remaining.';
        } elseif ($remainingAttempts == 0) {
            $message = 'You have reached the maximum number of password reset attempts.';
        }

        // Return JSON response for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'remainingAttempts' => $remainingAttempts,
                'isWarning' => $remainingAttempts == 1,
                'maxAttemptsReached' => $remainingAttempts == 0
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Show reset password form
     */
    public function showResetPasswordForm(Request $request, $token)
    {
        $email = $request->get('email');
        
        // Check if we have valid token/email in session (for reload)
        $sessionToken = session('password_reset_token');
        $sessionEmail = session('password_reset_email');
        
        // If reloading and have valid session data matching current token/email
        if ($sessionToken && $sessionEmail && $sessionToken === $token && $sessionEmail === $email) {
            // Verify token still exists in database
            $passwordReset = DB::table('password_resets')
                ->where('email', $email)
                ->first();

            if ($passwordReset && Hash::check($token, $passwordReset->token)) {
                // Check if token is expired (60 minutes)
                if (now()->diffInMinutes($passwordReset->created_at) <= 60) {
                    // Token still valid, show form (allow reload)
                    return view('auth.reset-password', [
                        'token' => $token,
                        'email' => $email,
                    ]);
                }
            }
        }
        
        // First time access - verify signed URL
        if (!$request->hasValidSignature()) {
            return redirect()->route('login')
                ->withErrors(['token' => 'Invalid or expired reset link.']);
        }

        // Verify token exists in database
        $passwordReset = DB::table('password_resets')
            ->where('email', $email)
            ->first();

        if (!$passwordReset || !Hash::check($token, $passwordReset->token)) {
            return redirect()->route('login')
                ->withErrors(['token' => 'Invalid or expired reset token.']);
        }

        // Check if token is expired (60 minutes)
        if (now()->diffInMinutes($passwordReset->created_at) > 60) {
            return redirect()->route('login')
                ->withErrors(['token' => 'Reset link has expired. Please request a new one.']);
        }

        // Store token and email in session for reload support
        session([
            'password_reset_token' => $token,
            'password_reset_email' => $email,
        ]);

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    /**
     * Reload reset password form (for page reload without signed URL)
     */
    public function reloadResetPasswordForm(Request $request)
    {
        // Get token and email from session
        $token = session('password_reset_token');
        $email = session('password_reset_email');
        
        if (!$token || !$email) {
            return redirect()->route('login')
                ->withErrors(['token' => 'Please use the reset link from your email.']);
        }

        // Verify token still exists in database
        $passwordReset = DB::table('password_resets')
            ->where('email', $email)
            ->first();

        if (!$passwordReset || !Hash::check($token, $passwordReset->token)) {
            // Clear invalid session
            session()->forget('password_reset_token');
            session()->forget('password_reset_email');
            return redirect()->route('login')
                ->withErrors(['token' => 'Invalid or expired reset token.']);
        }

        // Check if token is expired (60 minutes)
        if (now()->diffInMinutes($passwordReset->created_at) > 60) {
            // Clear expired session
            session()->forget('password_reset_token');
            session()->forget('password_reset_email');
            return redirect()->route('login')
                ->withErrors(['token' => 'Reset link has expired. Please request a new one.']);
        }

        // Token still valid, show form
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    /**
     * Reset password without current password
     */
    public function resetPasswordWithoutCurrent(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Verify token
        $passwordReset = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset || !Hash::check($request->token, $passwordReset->token)) {
            return back()->withErrors(['token' => 'Invalid or expired reset token.']);
        }

        // Check if token is expired
        if (now()->diffInMinutes($passwordReset->created_at) > 60) {
            return back()->withErrors(['token' => 'Reset link has expired. Please request a new one.']);
        }

        // Find user
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Delete used token
        DB::table('password_resets')->where('email', $request->email)->delete();

        // Clear reset token session data
        session()->forget('password_reset_token');
        session()->forget('password_reset_email');

        // Reset password reset attempts counter
        $resetAttemptsKey = 'password_reset_attempts_' . $user->id;
        session()->forget($resetAttemptsKey);

        // Logout user to force re-login with new password
        Auth::logout();

        return redirect()->route('login')
            ->with('success', 'Your password has been reset successfully! Please login with your new password.');
    }
}