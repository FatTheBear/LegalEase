@extends('layouts.auth')

@section('title', 'Sign In - LegalEase')

@section('content')
<div class="auth-card p-5">
    <div class="text-center mb-4">
        <h1 class="h3 mb-3 text-primary">
            <i class="fas fa-balance-scale me-2"></i>LegalEase
        </h1>
        <h2 class="h4 text-muted">Sign In to Your Account</h2>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div class="mb-3">
            <label for="email" class="form-label">
                <i class="fas fa-envelope me-1"></i>Email Address
            </label>
            <input type="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autocomplete="email" 
                   autofocus
                   placeholder="Enter your email">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">
                <i class="fas fa-lock me-1"></i>Password
            </label>
            <input type="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   id="password" 
                   name="password" 
                   required 
                   autocomplete="current-password"
                   placeholder="Enter your password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">
                Remember me
            </label>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-sign-in-alt me-2"></i>Sign In
            </button>
        </div>
    </form>

    <hr class="my-4">

    <div class="text-center">
        <p class="mb-3 text-muted">Don't have an account?</p>
        <div class="row g-2">
            <div class="col-6">
                <a href="{{ route('register.customer') }}" class="btn btn-outline-success w-100">
                    <i class="fas fa-user me-2"></i>Sign Up as Customer
                </a>
            </div>
            <div class="col-6">
                <a href="{{ route('register.lawyer') }}" class="btn btn-outline-warning w-100">
                    <i class="fas fa-user-tie me-2"></i>Sign Up as Lawyer
                </a>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="#" class="text-muted small">
            <i class="fas fa-key me-1"></i>Forgot Password?
        </a>
    </div>
</div>
@endsection