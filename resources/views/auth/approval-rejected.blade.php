@extends('layouts.app')

@section('title', 'Account Rejected')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-x-circle me-2"></i>
                        Account Registration Rejected
                    </h4>
                </div>
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-x-circle-fill text-danger" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h3 class="mb-3">Registration Not Approved</h3>
                    
                    <p class="lead mb-4">
                        Unfortunately, your account registration has been rejected by an administrator. 
                        This may be due to incomplete information or other verification issues.
                    </p>
                    
                    <div class="alert alert-warning" role="alert">
                        <h5 class="alert-heading">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            What can you do?
                        </h5>
                        <ul class="list-unstyled mb-0 text-start">
                            <li class="mb-2">
                                <i class="bi bi-arrow-right text-primary me-2"></i>
                                Contact support to understand the reason for rejection
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-arrow-right text-primary me-2"></i>
                                Provide additional documentation if required
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-arrow-right text-primary me-2"></i>
                                Register again with correct information
                            </li>
                        </ul>
                    </div>
                    
                    <div class="mt-4">
                        <div class="mb-3"><x-user-identity :user="auth()->user()" :size="48" :show-email="true" /></div>
                        <p class="text-muted">
                            <strong>Account Details:</strong><br>
                            Email: {{ auth()->user()->email }}<br>
                            Center ID: {{ auth()->user()->center_id ?? 'Not provided' }}<br>
                            Registration Date: {{ auth()->user()->created_at->format('M d, Y') }}<br>
                            @if(auth()->user()->approved_at)
                                Reviewed Date: {{ auth()->user()->approved_at->format('M d, Y') }}
                            @endif
                        </p>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('register') }}" class="btn btn-primary me-2">
                            <i class="bi bi-person-plus me-2"></i>
                            Register Again
                        </a>
                        
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
                            <a href="mailto:info@cydcactivitiesdb.or.tz">Cydc@Support</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
