@extends('layouts.auth')

@section('title', 'Lawyer Sign Up - LegalEase')

@section('content')
<div class="auth-card p-5">
    <div class="text-center mb-4">
        <h1 class="h3 mb-3 text-primary">
            <i class="fas fa-balance-scale me-2"></i>LegalEase
        </h1>
        <h2 class="h4 text-warning">
            <i class="fas fa-user-tie me-2"></i>Lawyer Registration
        </h2>
        <p class="text-muted">Join our platform as a professional lawyer</p>
        <div class="alert alert-info small">
            <i class="fas fa-info-circle me-1"></i>
            Your account will be reviewed by our admin team before activation.
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('register.lawyer.submit') }}" enctype="multipart/form-data">
        @csrf
        
        <!-- Personal Information -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i>Personal Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name *</label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required 
                           placeholder="Enter your full name">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address *</label>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           placeholder="Enter your professional email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required 
                               placeholder="Create a strong password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password *</label>
                        <input type="password" 
                               class="form-control" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required 
                               placeholder="Confirm your password">
                    </div>
                </div>
            </div>
        </div>

        <!-- Professional Information -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-briefcase me-2"></i>Professional Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="specialization" class="form-label">Specialization *</label>
                    <input type="text" 
                           class="form-control @error('specialization') is-invalid @enderror" 
                           id="specialization" 
                           name="specialization" 
                           value="{{ old('specialization') }}" 
                           required 
                           placeholder="e.g., Criminal Law, Corporate Law, Family Law">
                    @error('specialization')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="experience_years" class="form-label">Years of Experience *</label>
                        <input type="number" 
                               class="form-control @error('experience_years') is-invalid @enderror" 
                               id="experience_years" 
                               name="experience_years" 
                               value="{{ old('experience_years') }}" 
                               min="0" 
                               required 
                               placeholder="Years">
                        @error('experience_years')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="license_number" class="form-label">License Number *</label>
                        <input type="text" 
                               class="form-control @error('license_number') is-invalid @enderror" 
                               id="license_number" 
                               name="license_number" 
                               value="{{ old('license_number') }}" 
                               required 
                               placeholder="Professional license number">
                        @error('license_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="workplace" class="form-label">Current Workplace *</label>
                    <input type="text" 
                           class="form-control @error('workplace') is-invalid @enderror" 
                           id="workplace" 
                           name="workplace" 
                           value="{{ old('workplace') }}" 
                           required 
                           placeholder="Law firm, organization, or self-employed">
                    @error('workplace')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Document Upload -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-file-upload me-2"></i>Required Documents</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="documents" class="form-label">Upload Certificates & Licenses *</label>
                    <input type="file" 
                           class="form-control @error('documents.*') is-invalid @enderror" 
                           id="documents" 
                           name="documents[]" 
                           multiple 
                           accept=".pdf,.jpg,.jpeg,.png" 
                           required>
                    <div class="form-text">
                        <i class="fas fa-info-circle me-1"></i>
                        Upload your law degree, bar admission certificate, professional licenses, etc. 
                        <br>Accepted formats: PDF, JPG, PNG. Maximum 2MB per file.
                    </div>
                    @error('documents.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="file-preview" class="mt-3"></div>
            </div>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-warning btn-lg">
                <i class="fas fa-paper-plane me-2"></i>Submit Application for Review
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
        <p class="text-muted small mb-1">Looking for legal services?</p>
        <a href="{{ route('register.customer') }}" class="text-success">
            <i class="fas fa-user me-1"></i>Register as Customer instead
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('documents').addEventListener('change', function(e) {
    const preview = document.getElementById('file-preview');
    preview.innerHTML = '';
    
    if (e.target.files.length > 0) {
        const fileList = document.createElement('div');
        fileList.className = 'mt-2';
        
        for (let i = 0; i < e.target.files.length; i++) {
            const file = e.target.files[i];
            const fileItem = document.createElement('div');
            fileItem.className = 'alert alert-light d-flex align-items-center mb-2';
            fileItem.innerHTML = `
                <i class="fas fa-file me-2"></i>
                <span class="me-auto">${file.name}</span>
                <small class="text-muted">${(file.size / 1024 / 1024).toFixed(2)} MB</small>
            `;
            fileList.appendChild(fileItem);
        }
        
        preview.appendChild(fileList);
    }
});
</script>
@endsection
