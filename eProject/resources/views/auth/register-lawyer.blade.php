@extends('layouts.app')
@section('title', 'Lawyer Registration')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h2 class="mb-4 text-center">Lawyer Registration</h2>
                
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> 
                    Your account will be activated after Admin approves your profile and professional license.
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.lawyer.submit') }}" enctype="multipart/form-data" novalidate>
                    @csrf
                    
                    <h5 class="mb-3">Personal Information</h5>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            <small class="text-muted">Minimum 6 characters</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Professional Information</h5>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Specialization <span class="text-danger">*</span></label>
                            <select name="specialization" class="form-select @error('specialization') is-invalid @enderror">
                                <option value="">-- Select specialization --</option>
                                <option value="Criminal Law" {{ old('specialization') == 'Criminal Law' ? 'selected' : '' }}>Criminal Law</option>
                                <option value="Civil Law" {{ old('specialization') == 'Civil Law' ? 'selected' : '' }}>Civil Law</option>
                                <option value="Family Law" {{ old('specialization') == 'Family Law' ? 'selected' : '' }}>Family Law</option>
                                <option value="Corporate Law" {{ old('specialization') == 'Corporate Law' ? 'selected' : '' }}>Corporate Law</option>
                                <option value="Real Estate Law" {{ old('specialization') == 'Real Estate Law' ? 'selected' : '' }}>Real Estate Law</option>
                                <option value="Labor Law" {{ old('specialization') == 'Labor Law' ? 'selected' : '' }}>Labor Law</option>
                                <option value="Other" {{ old('specialization') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('specialization')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Years of Experience</label>
                            <input type="number" name="experience" class="form-control @error('experience') is-invalid @enderror" 
                                   value="{{ old('experience') }}" min="0">
                            @error('experience')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">License Number <span class="text-danger">*</span></label>
                        <input type="text" name="license_number" class="form-control @error('license_number') is-invalid @enderror" 
                               value="{{ old('license_number') }}">
                        @error('license_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload Professional License <span class="text-danger">*</span></label>
                        <input type="file" name="certificate" class="form-control @error('certificate') is-invalid @enderror" 
                               accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">Format: PDF, JPG, PNG. Maximum 5MB</small>
                        @error('certificate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" 
                                   value="{{ old('city') }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Province/State</label>
                            <input type="text" name="province" class="form-control @error('province') is-invalid @enderror" 
                                   value="{{ old('province') }}">
                            @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bio</label>
                        <textarea name="bio" class="form-control @error('bio') is-invalid @enderror" 
                                  rows="4" placeholder="Brief description of your experience, achievements...">{{ old('bio') }}</textarea>
                        @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success w-100 mb-3">Register</button>
                </form>

                <hr>

                <div class="text-center">
                    <p class="mb-0">
                        <a href="{{ route('register.choice') }}" class="text-decoration-none">
                            ← Back to account type selection
                        </a>
                    </p>
                    <p class="mb-0 mt-2">Already have an account? 
                        <a href="{{ route('login') }}" class="text-decoration-none fw-bold">
                            Login now
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h2 class="mb-4 text-center">Đăng ký Luật sư</h2>
                
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> 
                    Tài khoản của bạn sẽ được kích hoạt sau khi Admin phê duyệt hồ sơ và chứng chỉ hành nghề.
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.lawyer.submit') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <h5 class="mb-3">Thông tin cá nhân</h5>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            <small class="text-muted">Tối thiểu 6 ký tự</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Thông tin nghề nghiệp</h5>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Chuyên môn <span class="text-danger">*</span></label>
                            <select name="specialization" class="form-select @error('specialization') is-invalid @enderror" required>
                                <option value="">-- Chọn chuyên môn --</option>
                                <option value="Luật hình sự" {{ old('specialization') == 'Luật hình sự' ? 'selected' : '' }}>Luật hình sự</option>
                                <option value="Luật dân sự" {{ old('specialization') == 'Luật dân sự' ? 'selected' : '' }}>Luật dân sự</option>
                                <option value="Luật gia đình" {{ old('specialization') == 'Luật gia đình' ? 'selected' : '' }}>Luật gia đình</option>
                                <option value="Luật doanh nghiệp" {{ old('specialization') == 'Luật doanh nghiệp' ? 'selected' : '' }}>Luật doanh nghiệp</option>
                                <option value="Luật bất động sản" {{ old('specialization') == 'Luật bất động sản' ? 'selected' : '' }}>Luật bất động sản</option>
                                <option value="Luật lao động" {{ old('specialization') == 'Luật lao động' ? 'selected' : '' }}>Luật lao động</option>
                                <option value="Khác" {{ old('specialization') == 'Khác' ? 'selected' : '' }}>Khác</option>
                            </select>
                            @error('specialization')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Số năm kinh nghiệm</label>
                            <input type="number" name="experience" class="form-control @error('experience') is-invalid @enderror" 
                                   value="{{ old('experience') }}" min="0">
                            @error('experience')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Số chứng chỉ hành nghề <span class="text-danger">*</span></label>
                        <input type="text" name="license_number" class="form-control @error('license_number') is-invalid @enderror" 
                               value="{{ old('license_number') }}" required>
                        @error('license_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload chứng chỉ hành nghề <span class="text-danger">*</span></label>
                        <input type="file" name="certificate" class="form-control @error('certificate') is-invalid @enderror" 
                               accept=".pdf,.jpg,.jpeg,.png" required>
                        <small class="text-muted">Định dạng: PDF, JPG, PNG. Tối đa 5MB</small>
                        @error('certificate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Thành phố</label>
                            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" 
                                   value="{{ old('city') }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tỉnh/Thành phố</label>
                            <input type="text" name="province" class="form-control @error('province') is-invalid @enderror" 
                                   value="{{ old('province') }}">
                            @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Giới thiệu bản thân</label>
                        <textarea name="bio" class="form-control @error('bio') is-invalid @enderror" 
                                  rows="4" placeholder="Mô tả ngắn về kinh nghiệm, thành tích...">{{ old('bio') }}</textarea>
                        @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success w-100 mb-3">Đăng ký</button>
                </form>

                <hr>

                <div class="text-center">
                    <p class="mb-0">
                        <a href="{{ route('register.choice') }}" class="text-decoration-none">
                            ← Quay lại chọn loại tài khoản
                        </a>
                    </p>
                    <p class="mb-0 mt-2">Đã có tài khoản? 
                        <a href="{{ route('login') }}" class="text-decoration-none fw-bold">
                            Đăng nhập ngay
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
