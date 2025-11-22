@extends('layouts.app')
@section('title', 'Lawyer Profile')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="glyphicon glyphicon-user"></i> Lawyer Profile Details
                        <a href="{{ route('admin.lawyers') }}" class="btn btn-default btn-sm pull-right">
                            <i class="glyphicon glyphicon-arrow-left"></i> Back to List
                        </a>
                    </h3>
                </div>
                <div class="panel-body">
                    <!-- Basic Info -->
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Basic Information</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Name</th>
                                    <td>{{ $lawyer->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $lawyer->email }}</td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td><span class="label label-info">{{ ucfirst($lawyer->role) }}</span></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($lawyer->status == 'active')
                                            <span class="label label-success">Active</span>
                                        @else
                                            <span class="label label-warning">{{ ucfirst($lawyer->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Approval Status</th>
                                    <td>
                                        @if($lawyer->approval_status == 'approved')
                                            <span class="label label-success">Approved</span>
                                        @elseif($lawyer->approval_status == 'pending')
                                            <span class="label label-warning">Pending</span>
                                        @else
                                            <span class="label label-danger">Rejected</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Email Verified</th>
                                    <td>
                                        @if($lawyer->email_verified_at)
                                            <span class="label label-success">✓ Verified</span>
                                            <br><small>{{ $lawyer->email_verified_at->format('M d, Y H:i') }}</small>
                                        @else
                                            <span class="label label-danger">Not Verified</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Registered</th>
                                    <td>{{ $lawyer->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h4>Professional Information</h4>
                            @if($lawyer->lawyerProfile)
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">Specialization</th>
                                        <td>{{ $lawyer->lawyerProfile->specialization ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Experience</th>
                                        <td>{{ $lawyer->lawyerProfile->experience ?? 0 }} years</td>
                                    </tr>
                                    <tr>
                                        <th>Bio</th>
                                        <td>{{ $lawyer->lawyerProfile->bio ?? 'No bio available' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Province</th>
                                        <td>{{ $lawyer->lawyerProfile->province ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                            @else
                                <div class="alert alert-info">
                                    <i class="glyphicon glyphicon-info-sign"></i> No professional profile created yet.
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <!-- Approval Actions -->
                    @if($lawyer->approval_status == 'pending')
                        <div class="alert alert-warning">
                            <h4><i class="glyphicon glyphicon-exclamation-sign"></i> Action Required</h4>
                            <p>This lawyer application is pending approval. Please review the information and take action.</p>
                            
                            <div class="btn-group" role="group">
                                <form action="{{ route('admin.lawyers.approve', $lawyer->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-lg" onclick="return confirm('Are you sure you want to approve this lawyer?')">
                                        <i class="glyphicon glyphicon-ok"></i> Approve Application
                                    </button>
                                </form>

                                <form action="{{ route('admin.lawyers.reject', $lawyer->id) }}" method="POST" style="display: inline; margin-left: 10px;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger btn-lg" onclick="return confirm('Are you sure you want to reject this lawyer?')">
                                        <i class="glyphicon glyphicon-remove"></i> Reject Application
                                    </button>
                                </form>
                            </div>
                        </div>
                    @elseif($lawyer->approval_status == 'approved')
                        <div class="alert alert-success">
                            <i class="glyphicon glyphicon-ok-sign"></i> This lawyer has been <strong>approved</strong>.
                        </div>
                    @else
                        <div class="alert alert-danger">
                            <i class="glyphicon glyphicon-ban-circle"></i> This lawyer application has been <strong>rejected</strong>.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
