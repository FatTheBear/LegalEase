@extends('layouts.app')
@section('title', 'Edit Profile')
@section('content')
<div class="container">
    <h2>Edit Profile</h2>
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('POST')
        <div class="mb-3">
            <label>FullName</label>
            <input type="text" name="name" value="{{ auth()->user()->name }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control">
        </div>
        {{-- <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" value="{{ auth()->user()->phone ?? '' }}" class="form-control">
        </div> --}}
        <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ route(auth()->user()->role === 'admin' ? 'admin.dashboard' : (auth()->user()->role === 'lawyer' ? 'lawyer.dashboard' : 'customer.dashboard')) }}" 
    class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection