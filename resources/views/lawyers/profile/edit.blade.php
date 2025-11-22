@extends('layouts.app')
@section('title', 'Edit Lawyer Profile')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Lawyer Profile</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('lawyer.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <h5 class="mt-4">Personal Information</h5>
                        <hr>

                        <div class="mb-3">
                            <label>Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>

                        <h5 class="mt-5">Professional Information</h5>
                        <hr>

                        <div class="mb-3">
                            <label>Specialization <span class="text-danger">*</span></label>
                            <input type="text" name="specialization" class="form-control" value="{{ old('specialization', Auth::user()->specialization) }}" placeholder="e.g., Criminal Law, Family Law" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Years of Experience <span class="text-danger">*</span></label>
                                <input type="number" name="years_of_experience" class="form-control" value="{{ old('years_of_experience', Auth::user()->years_of_experience) }}" min="0" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>License Number <span class="text-danger">*</span></label>
                                <input type="text" name="license_number" class="form-control" value="{{ old('license_number', Auth::user()->license_number) }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Current Workplace <span class="text-danger">*</span></label>
                            <input type="text" name="workplace" class="form-control" value="{{ old('workplace', Auth::user()->workplace) }}" placeholder="Law firm or self-employed" required>
                        </div>

                        <h5 class="mt-5">Required Documents</h5>
                        <hr>

                        <div class="mb-3">
                            <label>Upload Certificates & Licenses <span class="text-danger">*</span></label>
                            <input type="file" name="documents" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                            <small class="text-muted">Accepted: PDF, JPG, PNG. Max 2MB</small>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('lawyer.dashboard') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection