@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1 class="fw-bold mb-1">
            <i class="fas fa-users text-primary"></i> Manage Users
        </h1>
        <p class="text-muted mb-0">View and verify user accounts</p>
    </div>

    <div class="card">
        <div class="card-body">
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Email Verified</th>
                                <th>Admin Verified</th>
                                <th>Role</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td><strong>{{ $user->id }}</strong></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>{{ $user->name }}</div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success">  //badge
                                            <i class="fas fa-check-circle"></i> Verified  //tick 
                                        </span>
                                        <br>
                                        <small class="text-muted">{{ $user->email_verified_at->format('M d, Y') }}</small>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-clock"></i> Pending
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->verified_by_admin_at)
                                        <span class="badge bg-success"> //green badge
                                            <i class="fas fa-user-check"></i> Verified 
                                        </span>
                                        <br>
                                        <small class="text-muted">{{ $user->verified_by_admin_at->format('M d, Y H:i') }}</small>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="fas fa-user-times"></i> Not Verified  //cross icon
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->role === 'admin')
                                        <span class="badge bg-danger"> // red badge
                                            <i class="fas fa-user-shield"></i> Admin  
                                        </span>
                                    @else
                                        <span class="badge bg-primary">
                                            <i class="fas fa-user"></i> User
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $user->created_at->format('M d, Y') }}</small>
                                    <br>
                                    <small class="text-muted">{{ $user->created_at->format('h:i A') }}</small>
                                </td>
                                <td>
                                    @if(!$user->verified_by_admin_at && $user->role !== 'admin')
                                        <a href="{{ route('admin.users.verify', $user->id) }}" 
                                           class="btn btn-success btn-sm"
                                           onclick="return confirm('Are you sure you want to verify {{ $user->name }}? An email will be sent to {{ $user->email }}')">
                                            <i class="fas fa-check-circle"></i> Verify User
                                        </a>
                                    @elseif($user->verified_by_admin_at)
                                        <span class="badge bg-secondary"> //grey
                                            <i class="fas fa-check"></i> Already Verified
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                   //pagination
                <div class="mt-3">
                    {{ $users->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">No users found</h5>
                    <p class="text-muted">Users will appear here once they register.</p>
                </div>
            @endif
        </div>
    </div>
    //Statistics
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-users fa-2x text-primary mb-2"></i>
                    <h4>{{ $users->total() }}</h4>
                    <p class="text-muted mb-0">Total Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h4>{{ User::where('role', 'user')->whereNotNull('verified_by_admin_at')->count() }}</h4>
                    <p class="text-muted mb-0">Verified Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                    <h4>{{ User::where('role', 'user')->whereNull('verified_by_admin_at')->count() }}</h4>
                    <p class="text-muted mb-0">Pending Verification</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection