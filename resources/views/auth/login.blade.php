@extends('layouts.auth')

@section('title', 'Sign In - LegalEase')

@section('content')
<div>
    <h1 class="auth-title">
        <i class="fas fa-balance-scale me-2" style="color: #3a4b41;"></i>Welcome Back
    </h1>
    <p class="auth-subtitle">Sign in to your LegalEase account</p>

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

    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf
        
        <div class="mb-3">
            <label for="email" class="form-label">
                <i class="fas fa-envelope me-2" style="color: #3a4b41;"></i>Email Address
            </label>
            <input type="text" 
                   class="form-control @error('email') is-invalid @enderror" 
                   id="email" 
                   name="email" 
                   value="{{ old('email', request()->cookie('remember_email')) }}" 
                   required
                   autocomplete="email" 
                   autofocus
                   placeholder="Enter your email">
            @error('email')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">
                <i class="fas fa-lock me-2" style="color: #3a4b41;"></i>Password
            </label>
            <div class="password-input-wrapper">
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       required
                       autocomplete="current-password"
                       placeholder="Enter your password">
                <i class="fas fa-eye" id="togglePassword"></i>
            </div>
            @error('password')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1">
            <label class="form-check-label" for="remember">
                Remember me
            </label>
        </div>

        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-sign-in-alt me-2"></i>Sign In
            </button>
        </div>

        <div class="text-center auth-divider">OR</div>

        <div class="text-center mb-4">
            <p class="mb-3 text-muted">Don't have an account yet?</p>
            <div class="row g-2">
                <div class="col-6">
                    <a href="{{ route('register.customer') }}" class="btn btn-outline-secondary w-100" style="border-color: #3a4b41; color: #3a4b41;">
                        <i class="fas fa-user me-1"></i>Customer
                    </a>
                </div>
                <div class="col-6">
                    <a href="{{ route('register.lawyer') }}" class="btn btn-outline-secondary w-100" style="border-color: #3a4b41; color: #3a4b41;">
                        <i class="fas fa-user-tie me-1"></i>Lawyer
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="#" style="color: #3a4b41; text-decoration: none; font-size: 14px;">
                <i class="fas fa-key me-1"></i>Forgot Password?
            </a>
        </div>
    </form>
</div>
@endsection

@section('sidebar')
<div class="logo">
    <i class="fas fa-balance-scale"></i>
</div>
<h2>LegalEase</h2>
<p>Your trusted platform to connect with expert lawyers and manage your legal matters efficiently.</p>
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

document.getElementById('remember').addEventListener('change', function() {
    const label = document.querySelector('label[for="remember"]');
    if (this.checked) {
        label.classList.add('fw-semibold');
        label.style.color = '#3a4b41';
    } else {
        label.classList.remove('fw-semibold');
        label.style.color = '#666';
    }
});
</script>
@endsection
