@extends('layouts.auth')

@section('title', 'Reset Password - LegalEase')

@section('content')
<div>
    <h1 class="auth-title">
        <i class="fas fa-shield-alt me-2" style="color: #3a4b41;"></i>Reset Your Password
    </h1>
    <p class="auth-subtitle">Enter your new password below to complete the reset process</p>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.reset.password.submit') }}" novalidate>
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="mb-3">
            <label for="password" class="form-label">
                <i class="fas fa-lock me-2" style="color: #3a4b41;"></i>New Password
            </label>
            <div class="password-input-wrapper">
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       required
                       autocomplete="new-password" 
                       autofocus
                       placeholder="Enter your new password">
                <i class="fas fa-eye" id="togglePassword" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #999; cursor: pointer; z-index: 10; font-size: 16px;"></i>
            </div>
            @error('password')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
            <small class="text-muted">Password must be at least 8 characters long.</small>
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">
                <i class="fas fa-lock me-2" style="color: #3a4b41;"></i>Confirm New Password
            </label>
            <div class="password-input-wrapper">
                <input type="password" 
                       class="form-control @error('password_confirmation') is-invalid @enderror" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       required
                       autocomplete="new-password"
                       placeholder="Confirm your new password">
                <i class="fas fa-eye" id="togglePasswordConfirmation" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #999; cursor: pointer; z-index: 10; font-size: 16px;"></i>
            </div>
            @error('password_confirmation')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3" style="background-color: #3a4b41; border-color: #3a4b41;">
            <i class="fas fa-shield-check me-2"></i>Reset Password
        </button>

        <div class="text-center">
            <a href="{{ route('login') }}" class="text-decoration-none" style="color: #3a4b41;">
                <i class="fas fa-arrow-left me-1"></i>Back to Login
            </a>
        </div>
    </form>
</div>
@endsection

@section('sidebar')
<div class="logo">
    <i class="fas fa-shield-alt"></i>
</div>
<h2>Reset Your Password</h2>
<p>Enter your new password to regain access to your LegalEase account. Your password must be secure and at least 8 characters long.</p>
@endsection

@section('scripts')
<script>
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        this.classList.remove('fa-eye');
        this.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        this.classList.add('fa-eye');
        this.classList.remove('fa-eye-slash');
    }
});

document.getElementById('togglePasswordConfirmation').addEventListener('click', function() {
    const passwordInput = document.getElementById('password_confirmation');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        this.classList.remove('fa-eye');
        this.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        this.classList.add('fa-eye');
        this.classList.remove('fa-eye-slash');
    }
});
</script>
@endsection

