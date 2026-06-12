@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Evaluations</h4>
                    <a href="{{ route('evaluations.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add New Evaluation
                    </a>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>Coming Soon!</strong> The evaluations management system is under development.
                        This page will allow you to:
                        <ul class="mt-2 mb-0">
                            <li>Create and manage evaluation forms</li>
                            <li>Track evaluation responses</li>
                            <li>Generate evaluation reports</li>
                            <li>Monitor evaluation progress</li>
                        </ul>
                    </div>
                    
                    <div class="text-center py-4">
                        <i class="bi bi-clipboard-check display-1 text-muted"></i>
                        <p class="text-muted mt-3">No evaluations available yet.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection