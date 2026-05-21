@extends('layouts.app')

@section('title', 'Profile Settings')

@section('content')
<div class="profile-wrapper">
    <div class="profile-header">
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="page-title">
                        <i class="fas fa-user-circle me-2"></i>
                        Profile Settings
                    </h1>
                    <p class="page-subtitle">Manage your account information and preferences</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4">
        <div class="row g-4">
            <!-- Profile Card -->
            <div class="col-lg-4">
                <div class="profile-card">
                    <div class="profile-card-header">
                        <!-- Avatar Only (No Upload) -->
                        <div class="profile-image-container">
                            <img src="{{ $user->profile_image_url }}" 
                                 alt="Profile Avatar" 
                                 class="profile-avatar">
                        </div>
                        <h4 class="profile-name">{{ $user->name }}</h4>
                        <p class="profile-email">{{ $user->email }}</p>
                        @if($user->student_id)
                        <p class="profile-id">
                            <i class="fas fa-id-card me-2"></i>
                            {{ $user->student_id }}
                        </p>
                        @endif
                    </div>

                    <div class="profile-card-body">
                        <h6 class="stats-title">Academic Summary</h6>
                        
                        <div class="stat-item">
                            <div class="stat-icon bg-gradient-purple">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="stat-info">
                                <p class="stat-label">Overall GPA</p>
                                <h3 class="stat-value">{{ number_format($overallGPA, 2) }}</h3>
                            </div>
                        </div>

                        <div class="stat-item">
                            <div class="stat-icon bg-gradient-green">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div class="stat-info">
                                <p class="stat-label">Total Semesters</p>
                                <h3 class="stat-value">{{ $totalSemesters }}</h3>
                            </div>
                        </div>

                        <div class="stat-item">
                            <div class="stat-icon bg-gradient-blue">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="stat-info">
                                <p class="stat-label">Total Courses</p>
                                <h3 class="stat-value">{{ $totalCourses }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="quick-actions-card">
                    <h6 class="card-title">Quick Actions</h6>
                    <div class="quick-actions-list">
                        <a href="{{ route('dashboard') }}" class="quick-action-item">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('reports.transcript') }}" class="quick-action-item">
                            <i class="fas fa-file-alt"></i>
                            <span>Transcript</span>
                        </a>
                        <a href="{{ route('tasks.index') }}" class="quick-action-item">
                            <i class="fas fa-tasks"></i>
                            <span>Tasks</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Settings Forms -->
            <div class="col-lg-8">
                <!-- Personal Information -->
                <div class="settings-card">
                    <div class="settings-card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-user me-2 text-primary"></i>
                            Personal Information
                        </h5>
                    </div>
                    <div class="settings-card-body">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">
                                        Full Name <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group-modern">
                                        <span class="input-icon">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control-modern @error('name') is-invalid @enderror" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name', $user->name) }}" 
                                               required>
                                    </div>
                                    @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">
                                        Email Address <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group-modern">
                                        <span class="input-icon">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input type="email" 
                                               class="form-control-modern @error('email') is-invalid @enderror" 
                                               id="email" 
                                               name="email" 
                                               value="{{ old('email', $user->email) }}" 
                                               required>
                                    </div>
                                    @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <div class="input-group-modern">
                                        <span class="input-icon">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control-modern @error('phone') is-invalid @enderror" 
                                               id="phone" 
                                               name="phone" 
                                               value="{{ old('phone', $user->phone) }}"
                                               placeholder="+92 300 1234567">
                                    </div>
                                    @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="student_id" class="form-label">Student ID</label>
                                    <div class="input-group-modern">
                                        <span class="input-icon">
                                            <i class="fas fa-id-card"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control-modern @error('student_id') is-invalid @enderror" 
                                               id="student_id" 
                                               name="student_id" 
                                               value="{{ old('student_id', $user->student_id) }}"
                                               placeholder="e.g., 2021-CS-123">
                                    </div>
                                    @error('student_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="degree" class="form-label">Degree Program</label>
                                    <div class="input-group-modern">
                                        <span class="input-icon">
                                            <i class="fas fa-graduation-cap"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control-modern @error('degree') is-invalid @enderror" 
                                               id="degree" 
                                               name="degree" 
                                               value="{{ old('degree', $user->degree) }}"
                                               placeholder="e.g., Bachelor of Science">
                                    </div>
                                    @error('degree')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="department" class="form-label">Department</label>
                                    <div class="input-group-modern">
                                        <span class="input-icon">
                                            <i class="fas fa-building"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control-modern @error('department') is-invalid @enderror" 
                                               id="department" 
                                               name="department" 
                                               value="{{ old('department', $user->department) }}"
                                               placeholder="e.g., Computer Science">
                                    </div>
                                    @error('department')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="bio" class="form-label">Bio</label>
                                <textarea class="form-control-modern @error('bio') is-invalid @enderror" 
                                          id="bio" 
                                          name="bio" 
                                          rows="4" 
                                          placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Maximum 500 characters</small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary-modern">
                                    <i class="fas fa-save me-2"></i> Save Changes
                                </button>
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary-modern">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="settings-card mt-4">
                    <div class="settings-card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-lock me-2 text-warning"></i>
                            Change Password
                        </h5>
                    </div>
                    <div class="settings-card-body">
                        <form action="{{ route('profile.password') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="current_password" class="form-label">
                                    Current Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group-modern">
                                    <span class="input-icon">
                                        <i class="fas fa-key"></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control-modern @error('current_password') is-invalid @enderror" 
                                           id="current_password" 
                                           name="current_password" 
                                           required>
                                </div>
                                @error('current_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">
                                        New Password <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group-modern">
                                        <span class="input-icon">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" 
                                               class="form-control-modern @error('password') is-invalid @enderror" 
                                               id="password" 
                                               name="password" 
                                               required>
                                    </div>
                                    @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">
                                        Confirm New Password <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group-modern">
                                        <span class="input-icon">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="password" 
                                               class="form-control-modern" 
                                               id="password_confirmation" 
                                               name="password_confirmation" 
                                               required>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info-modern">
                                <i class="fas fa-info-circle me-2"></i>
                                Password must be at least 6 characters long
                            </div>

                            <button type="submit" class="btn btn-primary-modern">
                                <i class="fas fa-key me-2"></i> Update Password
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="settings-card mt-4 border-danger">
                    <div class="settings-card-header bg-danger-light">
                        <h5 class="mb-0 text-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Danger Zone
                        </h5>
                    </div>
                    <div class="settings-card-body">
                        <p class="text-muted mb-3">
                            Once you delete your account, there is no going back. All your data including 
                            semesters, courses, grades, and tasks will be permanently deleted.
                        </p>
                        <button type="button" 
                                class="btn btn-danger-modern" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i> Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modern-modal">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                    Delete Account
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('profile.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="alert alert-danger-modern">
                        <strong>Warning:</strong> This action cannot be undone!
                    </div>
                    <p class="mb-3">All your data will be permanently deleted including:</p>
                    <ul class="mb-4">
                        <li>All semesters and courses</li>
                        <li>All grades and GPA records</li>
                        <li>All tasks and attendance records</li>
                        <li>Profile information and settings</li>
                    </ul>
                    
                    <div class="mb-3">
                        <label for="delete_password" class="form-label">
                            Enter your password to confirm:
                        </label>
                        <input type="password" 
                               class="form-control-modern" 
                               id="delete_password" 
                               name="password" 
                               required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary-modern" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-danger-modern">
                        Delete My Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.profile-wrapper {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
    padding-bottom: 40px;
}

.profile-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 40px 0;
    margin-bottom: 40px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.page-title {
    color: white;
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 10px;
    text-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.page-subtitle {
    color: rgba(255,255,255,0.9);
    font-size: 1rem;
    margin: 0;
}

.profile-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    overflow: hidden;
    margin-bottom: 20px;
}

.profile-card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 40px 30px;
    text-align: center;
    color: white;
}

.profile-image-container {
    display: inline-block;
    margin-bottom: 20px;
}

.profile-avatar {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid rgba(255,255,255,0.3);
    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
}

.profile-name {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 5px;
}

.profile-email {
    opacity: 0.9;
    margin-bottom: 5px;
}

.profile-id {
    opacity: 0.9;
    font-size: 14px;
    margin: 0;
}

.profile-card-body {
    padding: 30px;
}

.stats-title {
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 20px;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 12px;
    transition: all 0.3s;
}

.stat-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
}

.bg-gradient-purple {
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.bg-gradient-green {
    background: linear-gradient(135deg, #10b981, #059669);
}

.bg-gradient-blue {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.stat-info {
    flex: 1;
}

.stat-label {
    font-size: 13px;
    color: #6c757d;
    margin-bottom: 5px;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0;
}

.quick-actions-card {
    background: white;
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

.card-title {
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 20px;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.quick-actions-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.quick-action-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 12px 15px;
    background: #f8f9fa;
    border-radius: 10px;
    color: #2d3748;
    text-decoration: none;
    transition: all 0.3s;
}

.quick-action-item:hover {
    background: #667eea;
    color: white;
    transform: translateX(5px);
}

.quick-action-item i {
    width: 20px;
    text-align: center;
}

.settings-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.settings-card-header {
    padding: 25px 30px;
    border-bottom: 2px solid #f0f0f0;
    background: linear-gradient(to right, #fafafa, #ffffff);
}

.settings-card-header h5 {
    font-weight: 700;
    color: #2d3748;
}

.settings-card-body {
    padding: 30px;
}

.form-label {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 8px;
    font-size: 14px;
}

.input-group-modern {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    z-index: 10;
}

.form-control-modern {
    width: 100%;
    padding: 12px 15px 12px 45px;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    font-size: 14px;
    transition: all 0.3s;
}

.form-control-modern:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}

textarea.form-control-modern {
    padding: 12px 15px;
    resize: vertical;
}

.btn-primary-modern {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none;
    color: white;
    padding: 12px 30px;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.btn-primary-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-secondary-modern {
    background: #e9ecef;
    border: none;
    color: #2d3748;
    padding: 12px 30px;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s;
}

.btn-secondary-modern:hover {
    background: #dee2e6;
    color: #2d3748;
}

.btn-danger-modern {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border: none;
    color: white;
    padding: 12px 30px;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

.btn-danger-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
    color: white;
}

.alert-info-modern {
    background: linear-gradient(135deg, #e0f2fe, #bae6fd);
    border: none;
    border-radius: 12px;
    padding: 15px 20px;
    color: #0c4a6e;
}

.alert-danger-modern {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    border: none;
    border-radius: 12px;
    padding: 15px 20px;
    color: #991b1b;
}

.border-danger {
    border: 2px solid #fee2e2 !important;
}

.bg-danger-light {
    background: linear-gradient(to right, #fee2e2, #fecaca) !important;
}

.modern-modal {
    border-radius: 20px;
    border: none;
    overflow: hidden;
}

.modern-modal .modal-header {
    padding: 25px 30px;
}

.modern-modal .modal-body {
    padding: 25px 30px;
}

.modern-modal .modal-footer {
    padding: 20px 30px;
}

@media (max-width: 768px) {
    .page-title {
        font-size: 1.5rem;
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
    }
    
    .stat-value {
        font-size: 1.2rem;
    }
}
</style>
@endpush