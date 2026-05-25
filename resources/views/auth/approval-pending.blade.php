@extends('layouts.app')

@section('title', 'Account Pending Approval')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="bi bi-clock-history me-2"></i>
                        Account Pending Approval
                    </h4>
                </div>
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-hourglass-split text-warning" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h3 class="mb-3">Your Account is Under Review</h3>
                    
                    <p class="lead mb-4">
                        Thank you for registering with CYDC! Your account has been created successfully, 
                        but it requires approval from an administrator before you can access the platform.
                    </p>
                    
                    <div class="alert alert-info" role="alert">
                        <h5 class="alert-heading">
                            <i class="bi bi-info-circle me-2"></i>
                            What happens next?
                        </h5>
                        <ul class="list-unstyled mb-0 text-start">
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                An administrator will review your registration details
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                You will receive an email notification once your account is approved
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                After approval, you can access your dashboard and start using the platform
                            </li>
                        </ul>
                    </div>
                    
                    <div class="mt-4">
                        <p class="text-muted">
                            <strong>Account Details:</strong><br>
                            Email: {{ auth()->user()->email }}<br>
                            Center ID: {{ auth()->user()->center_id ?? 'Not provided' }}<br>
                            Registration Date: {{ auth()->user()->created_at->format('M d, Y') }}
                        </p>
                    </div>
                    
                    <div class="mt-4">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                    
                    <div class="mt-3">
                        <small class="text-muted">
                            Need help? Contact support at 
                            <a href="mailto:support@cydcactivitiesdb.or.tz">support@cydcactivitiesdb.or.tz</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
