@extends('layouts.app')
@section('title', 'Profile Settings')


@section('content')
<div class="container py-4" style="margin-top: 70px;">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0"><i class="bi bi-person-gear me-2"></i>Profile Settings</h2>
                <a href="{{ route(auth()->user()->role === 'admin' ? 'admin.dashboard' : (auth()->user()->role === 'lawyer' ? 'lawyer.dashboard' : 'customer.dashboard')) }}" 
                   class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-dismissible fade show" role="alert" style="background-color: #3a4b41; color: #fff; border: none;">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Main Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-person-gear me-2"></i>Account Settings</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Avatar Section -->
                        <div class="col-md-3">
                            <div class="text-center border-end pe-3">
                                <div class="mb-3">
                                    <div id="avatarPreview" class="mb-2">
                                        @if(auth()->user()->hasAvatar())
                                            <img src="{{ auth()->user()->getAvatarUrl() }}" 
                                                 alt="{{ auth()->user()->name }}" 
                                                 class="rounded-circle border border-3 border-primary" 
                                                 id="currentAvatar"
                                                 style="width: 120px; height: 120px; object-fit: cover; display: block; margin: 0 auto;">
                                        @else
                                            <div class="rounded-circle bg-light border border-3 border-primary d-inline-block" 
                                                 id="currentAvatar"
                                                 style="width: 120px; height: 120px;">
                                            </div>
                                        @endif
                                    </div>
                                    <form action="{{ route('profile.update.avatar') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                                        @csrf
                                        <input type="file" 
                                               id="avatarInput" 
                                               name="avatar" 
                                               accept="image/*" 
                                               class="d-none @error('avatar') is-invalid @enderror">
                                        <button type="button" 
                                                class="btn btn-outline-primary btn-sm w-100 mb-2" 
                                                onclick="document.getElementById('avatarInput').click()">
                                            <i class="bi bi-camera me-1"></i>Change Avatar
                                        </button>
                                        <div id="uploadSection" class="d-none">
                                            <div id="filePreview" class="mb-2"></div>
                                            <button type="submit" class="btn btn-primary btn-sm w-100" id="uploadAvatarBtn">
                                                <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                                                <i class="bi bi-upload me-1"></i><span class="btn-text">Upload Avatar</span>
                                            </button>
                                        </div>
                                        <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">Max 2MB (JPG, PNG)</small>
                                        @error('avatar')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Forms Section -->
                        <div class="col-md-9">
                            <!-- Personal Information -->
                            <div class="mb-3 pb-3 border-bottom">
                                <form action="{{ route('profile.update') }}" method="POST">
                                    @csrf
                                    @php
                                        $user = auth()->user();
                                        $firstName = old('first_name', $user->customerProfile->first_name ?? '');
                                        $lastName = old('last_name', $user->customerProfile->last_name ?? '');
                                        
                                        // Nếu không có trong customerProfile, parse từ name
                                        if (empty($firstName) && !empty($user->name)) {
                                            $nameParts = explode(' ', $user->name, 2);
                                            $firstName = $nameParts[0] ?? '';
                                            $lastName = $nameParts[1] ?? '';
                                        }
                                    @endphp
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label mb-1"><i class="bi bi-person me-2"></i>First Name</label>
                                            <input type="text" 
                                                   name="first_name" 
                                                   value="{{ $firstName }}" 
                                                   class="form-control @error('first_name') is-invalid @enderror" 
                                                   placeholder="Enter your first name">
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label mb-1"><i class="bi bi-person me-2"></i>Last Name</label>
                                            <input type="text" 
                                                   name="last_name" 
                                                   value="{{ $lastName }}" 
                                                   class="form-control @error('last_name') is-invalid @enderror" 
                                                   placeholder="Enter your last name">
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label mb-1"><i class="bi bi-envelope me-2"></i>Email</label>
                                        <input type="email" 
                                               name="email" 
                                               value="{{ old('email', auth()->user()->email) }}" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               placeholder="Enter your email address">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary" id="updateInfoBtn">
                                        <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                                        <i class="bi bi-check-circle me-1"></i><span class="btn-text">Update Information</span>
                                    </button>
                                </form>
                            </div>

                            <!-- Change Password -->
                            <div>
                                <h6 class="mb-2"><i class="bi bi-shield-lock me-2"></i>Change Password</h6>
                                <form action="{{ route('profile.update.password') }}" method="POST">
                                    @csrf
                                    <div class="mb-2">
                                        <label class="form-label mb-1"><i class="bi bi-key me-2"></i>Current Password</label>
                                        <input type="password" 
                                               name="current_password" 
                                               class="form-control @error('current_password') is-invalid @enderror" 
                                               placeholder="Enter your current password">
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="mt-1">
                                            <a href="#" class="text-decoration-none text-muted small" id="forgotPasswordLink">
                                                <i class="bi bi-question-circle me-1"></i>Forgot Password
                                            </a>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label mb-1"><i class="bi bi-key-fill me-2"></i>New Password</label>
                                        <input type="password" 
                                               name="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               placeholder="Enter new password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label mb-1"><i class="bi bi-key-fill me-2"></i>Confirm New Password</label>
                                        <input type="password" 
                                               name="password_confirmation" 
                                               class="form-control @error('password_confirmation') is-invalid @enderror" 
                                               placeholder="Confirm new password">
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-warning" id="changePasswordBtn">
                                        <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                                        <i class="bi bi-shield-check me-1"></i><span class="btn-text">Change Password</span>
                                    </button>
                                </form>
                                
                                
                                <!-- Hidden form for forgot password -->
                                <form action="{{ route('profile.forgot.password') }}" method="POST" id="forgotPasswordForm" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Forgot Password Success Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3a4b41; color: #fff;">
                <h5 class="modal-title">
                    <i class="bi bi-check-circle me-2"></i>Password Reset Link Sent
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0" id="forgotPasswordMessage">Password reset link has been sent to your email. Please check your inbox.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Max Attempts Reached Modal -->
<div class="modal fade" id="maxAttemptsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #3a4b41; color: #fff;">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle me-2"></i>Maximum Attempts Reached
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">You have reached the maximum number of password reset attempts. Please try again later.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<style>
    /* Loading overlay để tránh FOUC */
    .form-loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.9);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        backdrop-filter: blur(2px);
    }
    .form-loading-overlay.active {
        display: flex;
    }
    .form-loading-overlay .spinner-border {
        width: 3rem;
        height: 3rem;
        border-width: 0.3rem;
    }
</style>

<div class="form-loading-overlay" id="formLoadingOverlay">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<script>
    // Avatar preview handler
    document.getElementById('avatarInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const uploadSection = document.getElementById('uploadSection');
        const filePreview = document.getElementById('filePreview');
        const currentAvatar = document.getElementById('currentAvatar');
        
        if (file) {
            // Validate file size (2MB)
            if (file.size > 2048 * 1024) {
                alert('File size must be less than 2MB');
                e.target.value = '';
                return;
            }
            
            // Validate file type
            if (!file.type.match('image.*')) {
                alert('Please select an image file');
                e.target.value = '';
                return;
            }
            
            // Show preview
            const reader = new FileReader();
            reader.onload = function(event) {
                // Hide current avatar
                if (currentAvatar) {
                    currentAvatar.style.display = 'none';
                }
                
                // Show preview
                filePreview.innerHTML = `
                    <img src="${event.target.result}" 
                         alt="Preview" 
                         class="rounded-circle border border-3 border-primary" 
                         style="width: 120px; height: 120px; object-fit: cover; display: block; margin: 0 auto;">
                    <small class="text-muted d-block text-center mt-1">${file.name}</small>
                `;
                
                // Show upload section
                uploadSection.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            // Hide upload section if no file
            uploadSection.classList.add('d-none');
            filePreview.innerHTML = '';
            if (currentAvatar) {
                currentAvatar.style.display = 'block';
            }
        }
    });

    // Helper function để show loading state
    function showLoadingState(button) {
        const spinner = button.querySelector('.spinner-border');
        const btnText = button.querySelector('.btn-text');
        const icon = button.querySelector('i');
        
        if (spinner) spinner.classList.remove('d-none');
        if (icon) icon.style.display = 'none';
        button.disabled = true;
        
        // Show overlay
        const overlay = document.getElementById('formLoadingOverlay');
        if (overlay) overlay.classList.add('active');
    }

    // Avatar form submit - AJAX
    document.getElementById('avatarForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const btn = document.getElementById('uploadAvatarBtn');
        const avatarPreview = document.getElementById('avatarPreview');
        const currentAvatar = document.getElementById('currentAvatar');
        const filePreview = document.getElementById('filePreview');
        const uploadSection = document.getElementById('uploadSection');
        const avatarInput = document.getElementById('avatarInput');
        
        // Check if file is selected
        if (!avatarInput.files || !avatarInput.files[0]) {
            alert('Please select an image file first.');
            return;
        }
        
        // Show loading state
        if (btn) {
            const spinner = btn.querySelector('.spinner-border');
            const btnText = btn.querySelector('.btn-text');
            if (spinner) spinner.classList.remove('d-none');
            if (btnText) btnText.textContent = 'Uploading...';
            btn.disabled = true;
        }
        
        // Prepare form data
        const formData = new FormData(form);
        
        // Send AJAX request
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => {
            return response.json().then(data => {
                return { status: response.status, data: data };
            });
        })
        .then(({ status, data }) => {
            // Reset button state
            if (btn) {
                const spinner = btn.querySelector('.spinner-border');
                const btnText = btn.querySelector('.btn-text');
                if (spinner) spinner.classList.add('d-none');
                if (btnText) btnText.textContent = 'Upload Avatar';
                btn.disabled = false;
            }
            
            if (data.success) {
                // Update avatar preview
                if (data.avatarUrl && avatarPreview) {
                    avatarPreview.innerHTML = `
                        <img src="${data.avatarUrl}" 
                             alt="{{ auth()->user()->name }}" 
                             class="rounded-circle border border-3 border-primary" 
                             id="currentAvatar"
                             style="width: 120px; height: 120px; object-fit: cover; display: block; margin: 0 auto;">
                    `;
                }
                
                // Hide upload section and clear preview
                if (uploadSection) uploadSection.classList.add('d-none');
                if (filePreview) filePreview.innerHTML = '';
                if (avatarInput) avatarInput.value = '';
                
                // Show success message
                const successAlert = document.createElement('div');
                successAlert.className = 'alert alert-success alert-dismissible fade show mt-2';
                successAlert.style.cssText = 'background-color: #3a4b41; color: #fff; border: none;';
                successAlert.innerHTML = `
                    <i class="bi bi-check-circle me-2"></i>${data.message}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                `;
                form.parentElement.insertBefore(successAlert, form.nextSibling);
                
                // Auto remove alert after 3 seconds
                setTimeout(() => {
                    successAlert.remove();
                }, 3000);
                
                // Update navbar avatar without reload
                const navbarAvatar = document.querySelector('.navbar .rounded-circle img, .navbar .rounded-circle');
                if (navbarAvatar && data.avatarUrl) {
                    if (navbarAvatar.tagName === 'IMG') {
                        navbarAvatar.src = data.avatarUrl + '?t=' + new Date().getTime();
                    } else {
                        // Replace placeholder with image
                        const img = document.createElement('img');
                        img.src = data.avatarUrl + '?t=' + new Date().getTime();
                        img.alt = '{{ auth()->user()->name }}';
                        img.className = 'rounded-circle me-2 border border-2 border-primary';
                        img.style.cssText = 'width: 32px; height: 32px; object-fit: cover;';
                        navbarAvatar.parentNode.replaceChild(img, navbarAvatar);
                    }
                }
            } else {
                // Show error message
                const errorAlert = document.createElement('div');
                errorAlert.className = 'alert alert-danger alert-dismissible fade show mt-2';
                errorAlert.innerHTML = `
                    <i class="bi bi-exclamation-triangle me-2"></i>${data.message || 'An error occurred. Please try again.'}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                form.parentElement.insertBefore(errorAlert, form.nextSibling);
                
                // Auto remove alert after 5 seconds
                setTimeout(() => {
                    errorAlert.remove();
                }, 5000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Reset button state
            if (btn) {
                const spinner = btn.querySelector('.spinner-border');
                const btnText = btn.querySelector('.btn-text');
                if (spinner) spinner.classList.add('d-none');
                if (btnText) btnText.textContent = 'Upload Avatar';
                btn.disabled = false;
            }
            
            // Show error message
            const errorAlert = document.createElement('div');
            errorAlert.className = 'alert alert-danger alert-dismissible fade show mt-2';
            errorAlert.innerHTML = `
                <i class="bi bi-exclamation-triangle me-2"></i>An error occurred. Please try again.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            form.parentElement.insertBefore(errorAlert, form.nextSibling);
            
            // Auto remove alert after 5 seconds
            setTimeout(() => {
                errorAlert.remove();
            }, 5000);
        });
    });

    // Profile update form submit
    const profileForm = document.querySelector('form[action="{{ route('profile.update') }}"]');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            const btn = document.getElementById('updateInfoBtn');
            if (btn) showLoadingState(btn);
        });
    }

    // Password change form submit
    const passwordForm = document.querySelector('form[action="{{ route('profile.update.password') }}"]');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            const btn = document.getElementById('changePasswordBtn');
            if (btn) showLoadingState(btn);
        });
    }

    // Forgot password AJAX handler
    document.getElementById('forgotPasswordLink').addEventListener('click', function(e) {
        e.preventDefault();
        
        const form = document.getElementById('forgotPasswordForm');
        const successModal = new bootstrap.Modal(document.getElementById('forgotPasswordModal'));
        const maxAttemptsModal = new bootstrap.Modal(document.getElementById('maxAttemptsModal'));
        const messageSpan = document.getElementById('forgotPasswordMessage');
        const link = this;
        
        // Disable link
        link.style.pointerEvents = 'none';
        link.style.opacity = '0.6';
        
        // Show loading state in modal
        if (messageSpan) {
            messageSpan.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Sending...';
        }
        successModal.show();
        
        // Prepare form data
        const formData = new FormData(form);
        
        // Get CSRF token from meta tag or form
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token');
        
        // Send AJAX request
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken || ''
            }
        })
        .then(response => {
            return response.json().then(data => {
                return { status: response.status, data: data };
            });
        })
        .then(({ status, data }) => {
            // Enable link
            link.style.pointerEvents = 'auto';
            link.style.opacity = '1';
            
            // Close success modal first
            successModal.hide();
            
            if (data.maxAttemptsReached || status === 429) {
                // Show max attempts modal
                setTimeout(() => {
                    maxAttemptsModal.show();
                }, 300);
            } else                 if (data.success) {
                    // Show success message in modal
                    if (messageSpan) {
                        if (data.isWarning) {
                            // Lần 2: Hiển thị warning màu đen
                            messageSpan.innerHTML = '<span style="color: #000;"><i class="bi bi-exclamation-triangle me-2"></i>' + data.message + '</span>';
                        } else {
                            // Lần 1: Hiển thị success message bình thường
                            messageSpan.innerHTML = data.message;
                        }
                    }
                    setTimeout(() => {
                        successModal.show();
                    }, 300);
                } else {
                // Show error message
                if (messageSpan) {
                    messageSpan.innerHTML = '<span class="text-danger"><i class="bi bi-exclamation-triangle me-2"></i>' + (data.message || 'An error occurred. Please try again.') + '</span>';
                }
                setTimeout(() => {
                    successModal.show();
                }, 300);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Enable link
            link.style.pointerEvents = 'auto';
            link.style.opacity = '1';
            
            // Show error message
            if (messageSpan) {
                messageSpan.innerHTML = '<span class="text-danger"><i class="bi bi-exclamation-triangle me-2"></i>An error occurred. Please try again.</span>';
            }
            successModal.show();
        });
    });
</script>
@endsection