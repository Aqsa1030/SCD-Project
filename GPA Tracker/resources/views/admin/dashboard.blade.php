@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">
        <i class="fas fa-user-shield text-primary"></i> Admin Dashboard  //admin icon
    </h1>  

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>  //user icon
                    <h3 class="fw-bold">{{ $totalUsers }}</h3>
                    <p class="text-muted mb-0">Total Users</p>  //grey color
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>  //verified user
                    <h3 class="fw-bold">{{ $verifiedUsers }}</h3>
                    <p class="text-muted mb-0">Verified Users</p> 
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-3x text-warning mb-3"></i> //pending user ka icon  //yellow color
                    <h3 class="fw-bold">{{ $pendingUsers }}</h3>
                    <p class="text-muted mb-0">Pending Verification</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">Quick Actions</h5>
        </div>
        <div class="card-body">
            <a href="{{ route('admin.users') }}" class="btn btn-primary">
                <i class="fas fa-users"></i> View All Users
            </a>
        </div>
    </div>
</div>
@endsection