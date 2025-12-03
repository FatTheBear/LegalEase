@extends('layouts.auth')

@section('title', 'Customer Sign Up - LegalEase')

@section('content')
<div class="auth-card p-5">
    <div class="text-center mb-4">
        <h1 class="h3 mb-3 text-primary">
            <i class="fas fa-balance-scale me-2"></i>LegalEase
        </h1>
        <h2 class="h4 text-success">
            <i class="fas fa-user me-2"></i>Customer Registration
        </h2>
        <p class="text-muted">Join our platform to connect with professional lawyers</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                <i class="fas fa-user me-1"></i>Full Name
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
                <i class="fas fa-envelope me-1"></i>Email Address
            </label>
            <input type="text" 
                   class="form-control @error('email') is-invalid @enderror" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   autocomplete="email"
                   placeholder="Enter your email address">
            @error('email')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">
                <i class="fas fa-lock me-1"></i>Password
            </label>
            <div class="password-input-wrapper" style="position: relative;">
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       autocomplete="new-password"
                       placeholder="Create a strong password"
                       style="padding-right: 2.5rem;">
                <i class="fas fa-eye toggle-password-eye" data-target="password" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #666;"></i>
            </div>
            @error('password')
                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">
                <i class="fas fa-lock me-1"></i>Confirm Password
            </label>
            <div class="password-input-wrapper" style="position: relative;">
                <input type="password" 
                       class="form-control" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       autocomplete="new-password"
                       placeholder="Confirm your password"
                       style="padding-right: 2.5rem;">
                <i class="fas fa-eye toggle-password-eye" data-target="password_confirmation" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #666;"></i>
            </div>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-success btn-lg">
                <i class="fas fa-user-plus me-2"></i>Create Customer Account
            </button>
        </div>
    </form>

    <hr class="my-4">

    <div class="text-center">
        <p class="mb-2 text-muted">Already have an account?</p>
        <a href="{{ route('login') }}" class="btn btn-outline-primary">
            <i class="fas fa-sign-in-alt me-2"></i>Sign In
        </a>
    </div>

    <div class="text-center mt-3">
        <p class="text-muted small mb-1">Are you a lawyer?</p>
        <a href="{{ route('register.lawyer') }}" class="text-warning">
            <i class="fas fa-user-tie me-1"></i>Register as Lawyer instead
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.querySelectorAll('.toggle-password-eye').forEach(icon => {
    icon.addEventListener('click', function() {
        const targetId = this.getAttribute('data-target');
        const passwordInput = document.getElementById(targetId);
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            this.classList.add('fa-eye');
            this.classList.remove('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            this.classList.add('fa-eye-slash');
            this.classList.remove('fa-eye');
        }
    });
});
</script>
@endsection
