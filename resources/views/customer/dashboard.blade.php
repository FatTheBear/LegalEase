@extends('layouts.app')
@section('title', 'My Dashboard')

@section('content')
<style>
    :root {
        --primary: #6366f1;
        --secondary: #a0826d;
    }
    
    .dashboard-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        padding: 2rem;
        border-radius: 8px;
        margin-bottom: 2rem;
    }
    
    .dashboard-header h1 {
        margin: 0;
        font-size: 2rem;
    }
    
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
    }
    
    .action-card {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .action-card:hover {
        border-color: var(--primary);
        box-shadow: 0 6px 12px rgba(99, 102, 241, 0.15);
        transform: translateY(-3px);
    }
    
    .action-card i {
        font-size: 3rem;
        color: var(--primary);
        margin-bottom: 1rem;
        display: block;
    }
    
    .action-card h3 {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
        font-size: 1.2rem;
    }
    
    .action-card p {
        color: #666;
        margin-bottom: 1.5rem;
    }
    
    .action-card .btn {
        padding: 0.7rem 1.5rem;
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
        font-weight: 500;
    }
    
    .action-card .btn:hover {
        background-color: #0c3b0f;
        border-color: #123e1e;
    }
</style>

<div class="container mt-4">
    <!-- Header -->
    <div class="dashboard-header">
        <h1>My Dashboard</h1>
    </div>
    
    <!-- Quick Actions -->
    <div class="quick-actions">
        <div class="action-card">
            <i class="bi bi-search"></i>
            <h3>Find Lawyers</h3>
            <p>Search and browse available lawyers</p>
            <a href="{{ route('lawyers.index') }}" class="btn btn-sm">Browse Lawyers</a>
        </div>

        <div class="action-card">
            <i class="bi bi-calendar-check"></i>
            <h3>My Appointments</h3>
            <p>View and manage your bookings</p>
            <a href="{{ route('appointments.index') }}" class="btn btn-sm">View Appointments</a>
        </div>

        <div class="action-card">
            <i class="bi bi-person-circle"></i>
            <h3>My Profile</h3>
            <p>Update your personal information</p>
            <a href="{{ route('profile.edit') }}" class="btn btn-sm">Edit Profile</a>
        </div>
    </div>
</div>

@endsection
