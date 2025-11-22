@extends('layouts.app')
@section('title', 'Verify Email')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body p-5 text-center">
                    <i class="bi bi-envelope-check display-1 text-success mb-4"></i>
                    
                    <h2 class="mb-4">Verify Your Email Address</h2>
                    
                    <p class="text-muted mb-4">
                        We've sent a verification link to your email address. 
                        Please check your inbox and click the link to verify your account.
                    </p>

                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            A fresh verification link has been sent to your email address.
                        </div>
                    @endif

                    <div class="alert alert-info" role="alert">
                        <small>
                            <strong>Didn't receive the email?</strong>
                            <form method="POST" action="{{ route('verification.resend') }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-link p-0">Click here to request another</button>
                            </form>
                        </small>
                    </div>

                    <hr>

                    <p class="mb-3">
                        <a href="{{ route('logout') }}" class="text-muted" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    </p>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
