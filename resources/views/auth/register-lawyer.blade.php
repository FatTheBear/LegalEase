@extends('layouts.auth')

@section('title', 'Lawyer Sign Up - LegalEase')

@section('content')
<div style="max-height: 90vh; overflow-y: auto; padding-right: 10px;">
    <h1 class="auth-title">
        <i class="fas fa-user-tie me-2" style="color: #3a4b41;"></i>Join as Lawyer
    </h1>
    <p class="auth-subtitle">Register and grow your legal practice</p>

    <div class="alert alert-info small mb-3">
        <i class="fas fa-info-circle me-1"></i>
        <strong>Note:</strong> Your account will be reviewed by our admin team before activation.
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('register.lawyer.submit') }}" enctype="multipart/form-data" novalidate>
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
                        <div class="password-input-wrapper" style="position: relative;">
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required 
                                   placeholder="Create a strong password"
                                   style="padding-right: 2.5rem;">
                            <i class="fas fa-eye toggle-password-eye" data-target="password" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #666;"></i>
                        </div>
                        @error('password')
                            <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password *</label>
                        <div class="password-input-wrapper" style="position: relative;">
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required 
                                   placeholder="Confirm your password"
                                   style="padding-right: 2.5rem;">
                            <i class="fas fa-eye toggle-password-eye" data-target="password_confirmation" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #666;"></i>
                        </div>
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
                    <label for="documents" class="form-label">Upload Certificates & Licenses * <span class="badge bg-info ms-2">Max 3 files</span></label>
                    <input type="file" 
                           class="form-control @error('documents.*') is-invalid @enderror" 
                           id="documents" 
                           name="documents[]" 
                           multiple 
                           accept=".pdf,.jpg,.jpeg,.png" 
                           required>
                    <div class="form-text">
                        <i class="fas fa-info-circle me-1"></i>
                        Upload your law degree, bar admission certificate, professional licenses, and other relevant credentials. 
                        <br>Accepted formats: PDF, JPG, PNG. Maximum 3 files, 2MB per file.
                    </div>
                    @error('documents')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                    @error('documents.*')
                        <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>

                <div id="file-preview" class="mt-3"></div>
                <div id="error-message" class="alert alert-warning mt-2" style="display: none;">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <span id="error-text"></span>
                </div>
            </div>
        </div>

        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-paper-plane me-2"></i>Submit for Review
            </button>
        </div>

        <div class="text-center auth-divider">OR</div>

        <div class="text-center mb-4">
            <p class="mb-3 text-muted">Already have an account?</p>
            <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100" style="border-color: #3a4b41; color: #3a4b41;">
                <i class="fas fa-sign-in-alt me-2"></i>Sign In
            </a>
        </div>

        <div class="text-center">
            <p class="text-muted small">Need legal services instead?</p>
            <a href="{{ route('register.customer') }}" class="auth-link">
                <i class="fas fa-user me-1"></i>Register as Customer
            </a>
        </div>
    </form>
</div>
@endsection

@section('sidebar')
<div class="logo">
    <i class="fas fa-briefcase"></i>
</div>
<h2>Expand Your Practice</h2>
<p>Reach more clients, manage your legal practice efficiently, and grow your business on LegalEase platform.</p>
@endsection

@section('scripts')
<script>
const MAX_FILES = 3;
const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB in bytes

document.getElementById('documents').addEventListener('change', function(e) {
    const preview = document.getElementById('file-preview');
    const errorMessage = document.getElementById('error-message');
    const errorText = document.getElementById('error-text');
    preview.innerHTML = '';
    errorMessage.style.display = 'none';
    
    const files = e.target.files;
    let hasError = false;
    
    // Check file count
    if (files.length > MAX_FILES) {
        errorMessage.style.display = 'block';
        errorText.textContent = `You can only upload a maximum of ${MAX_FILES} certificates. You selected ${files.length} files.`;
        hasError = true;
    }
    
    if (files.length > 0) {
        const fileList = document.createElement('div');
        fileList.className = 'mt-2';
        
        for (let i = 0; i < Math.min(files.length, MAX_FILES); i++) {
            const file = files[i];
            const fileSize = file.size / (1024 * 1024);
            
            // Check individual file size
            let fileStatus = 'alert-light';
            let warningIcon = '';
            if (file.size > MAX_FILE_SIZE) {
                fileStatus = 'alert-danger';
                warningIcon = '<i class="fas fa-exclamation-circle me-2 text-danger"></i>';
                hasError = true;
            }
            
            const fileItem = document.createElement('div');
            fileItem.className = `alert ${fileStatus} d-flex align-items-center mb-2`;
            fileItem.innerHTML = `
                ${warningIcon || '<i class="fas fa-file me-2"></i>'}
                <span class="me-auto">${file.name}</span>
                <small class="${file.size > MAX_FILE_SIZE ? 'text-danger' : 'text-muted'}">${fileSize.toFixed(2)} MB</small>
            `;
            fileList.appendChild(fileItem);
        }
        
        // Show count info
        const countInfo = document.createElement('div');
        countInfo.className = 'alert alert-info mt-2';
        countInfo.innerHTML = `<i class="fas fa-check-circle me-2"></i>Selected: <strong>${Math.min(files.length, MAX_FILES)} of ${MAX_FILES}</strong> certificates`;
        fileList.appendChild(countInfo);
        
        preview.appendChild(fileList);
    }
});

// Toggle password visibility
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

@section('sidebar')
<div class="logo">
    <i class="fas fa-balance-scale"></i>
</div>
<h2>LegalEase</h2>
<p>Register as a lawyer and expand your client base on our trusted platform.</p>
@endsection
