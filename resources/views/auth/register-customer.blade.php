@extends('layouts.auth')

@section('title', 'Customer Sign Up - LegalEase')

@section('content')
<div>
    <h1 class="auth-title">
        <i class="fas fa-user me-2" style="color: #3a4b41;"></i>Join as Customer
    </h1>
    <p class="auth-subtitle">Create your account and connect with professional lawyers</p>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('register.customer.submit') }}" novalidate>
        @csrf
        
        <div class="mb-3">
            <label for="name" class="form-label">
                <i class="fas fa-user me-2" style="color: #3a4b41;"></i>Full Name
            </label>
            <input type="text" 
                   class="form-control @error('name') is-invalid @enderror" 
                   id="name" 
                   name="name" 
                   value="{{ old('name') }}" 
                   autocomplete="name" 
                   autofocus
                   placeholder="Enter your full name">
            @error('name')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">
                <i class="fas fa-envelope me-2" style="color: #3a4b41;"></i>Email Address
            </label>
            <input type="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   autocomplete="email"
                   placeholder="Enter your email">
            @error('email')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">
                <i class="fas fa-lock me-2" style="color: #3a4b41;"></i>Password
            </label>
            <div class="password-input-wrapper">
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       autocomplete="new-password"
                       placeholder="Enter your password">
                <i class="fas fa-eye toggle-password-eye" data-target="password"></i>
            </div>
            @error('password')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">
                <i class="fas fa-lock me-2" style="color: #3a4b41;"></i>Confirm Password
            </label>
            <div class="password-input-wrapper">
                <input type="password" 
                       class="form-control" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       autocomplete="new-password"
                       placeholder="Confirm your password">
                <i class="fas fa-eye toggle-password-eye" data-target="password_confirmation"></i>
            </div>
        </div>

        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-user-plus me-2"></i>Create Account
            </button>
        </div>

        <div class="text-center">
            <p class="mb-3 text-muted small">Already have an account?</p>
            <a href="{{ route('login') }}" style="color: #3a4b41; text-decoration: none;">
                <i class="fas fa-sign-in-alt me-1"></i>Sign In
            </a>
        </div>

        <div class="text-center mt-3">
            <p class="text-muted small mb-1">Are you a lawyer?</p>
            <a href="{{ route('register.lawyer') }}" class="text-warning">
                <i class="fas fa-user-tie me-1"></i>Register as Lawyer instead
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
<p>Join thousands of customers who trust LegalEase to connect them with expert legal professionals.</p>
@endsection

@section('scripts')
<script>
document.querySelectorAll('.toggle-password-eye').forEach(icon => {
    icon.addEventListener('click', function() {
        const targetId = this.getAttribute('data-target');
        const passwordInput = document.getElementById(targetId);
        
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
});
</script>
@endsection
