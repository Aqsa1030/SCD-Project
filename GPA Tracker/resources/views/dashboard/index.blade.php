@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-wrapper">
    <div class="welcome-header">
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="welcome-title">Welcome back, {{ auth()->user()->name }}! 👋</h1>
                    <p class="welcome-subtitle">Here's what's happening with your academics today.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4">
        <div class="row g-4 mb-4 stats-row">
            <div class="col-md-3">
                <div class="stat-card stat-card-gradient-purple">
                    <div class="stat-content">
                        <h6 class="stat-label">Overall GPA</h6>
                        <h2 class="stat-value">{{ number_format($overallGPA ?? 0, 2) }}</h2>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-bg-decoration"></div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card stat-card-gradient-pink">
                    <div class="stat-content">
                        <h6 class="stat-label">Total Courses</h6>
                        <h2 class="stat-value">{{ $totalCourses ?? 0 }}</h2>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-bg-decoration"></div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card stat-card-gradient-blue">
                    <div class="stat-content">
                        <h6 class="stat-label">Attendance</h6>
                        <h2 class="stat-value">{{ number_format($attendancePercentage ?? 0, 1) }}%</h2>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-bg-decoration"></div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card stat-card-gradient-orange">
                    <div class="stat-content">
                        <h6 class="stat-label">Pending Tasks</h6>
                        <h2 class="stat-value">{{ $pendingTasks->count() ?? 0 }}</h2>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div class="stat-bg-decoration"></div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="content-card modern-card">
                    <div class="card-header-custom">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-bar me-2 text-primary"></i>
                            Recent Grades
                        </h5>
                    </div>
                    <div class="card-body-custom">
                        @if(isset($recentGrades) && $recentGrades->count() > 0)
                            <div class="table-responsive">
                                <table class="table modern-table">
                                    <thead>
                                        <tr>
                                            <th>Course</th>
                                            <th class="text-center">Grade Point</th>
                                            <th class="text-center">Letter Grade</th>
                                            <th class="text-center">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentGrades as $grade)
                                        <tr>
                                            <td>
                                                <div class="course-info">
                                                    <strong>{{ $grade->course->name ?? 'N/A' }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $grade->course->code ?? '' }}</small>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="grade-point">{{ number_format($grade->grade_point, 2) }}</span>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $letter = strtolower($grade->letter_grade);
                                                    $badgeClass = 'success';
                                                    if(in_array($letter, ['a+', 'a', 'a-'])) $badgeClass = 'success';
                                                    elseif(in_array($letter, ['b+', 'b', 'b-'])) $badgeClass = 'primary';
                                                    elseif(in_array($letter, ['c+', 'c', 'c-'])) $badgeClass = 'warning';
                                                    else $badgeClass = 'danger';
                                                @endphp
                                                <span class="badge badge-grade bg-{{ $badgeClass }}">
                                                    {{ $grade->letter_grade }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    {{ $grade->created_at->format('M d, Y') }}
                                                </small>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <h5>No grades recorded yet</h5>
                                <p>Start tracking your academic performance</p>
                                <a href="{{ route('grades.create') }}" class="btn btn-primary btn-modern">
                                    <i class="fas fa-plus me-2"></i> Add First Grade
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="content-card modern-card">
                    <div class="card-header-custom">
                        <h5 class="mb-0">
                            <i class="fas fa-tasks me-2 text-warning"></i>
                            Upcoming Tasks
                        </h5>
                    </div>
                    <div class="card-body-custom">
                        @if(isset($pendingTasks) && $pendingTasks->count() > 0)
                            <div class="tasks-list">
                                @foreach($pendingTasks->take(5) as $task)
                                <div class="task-item">
                                    <div class="task-indicator task-indicator-{{ $task->priority }}"></div>
                                    <div class="task-content">
                                        <h6>{{ $task->title }}</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $task->due_date->format('M d, Y') }}
                                        </small>
                                    </div>
                                    <span class="badge badge-priority badge-priority-{{ $task->priority }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                            <div class="text-center mt-3">
                                <a href="{{ route('tasks.index') }}" class="btn btn-outline-primary btn-sm btn-modern">
                                    View All Tasks
                                </a>
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon text-success">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <h5>All caught up!</h5>
                                <p>No pending tasks at the moment</p>
                                <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm btn-modern">
                                    <i class="fas fa-plus me-2"></i> Create Task
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="content-card modern-card">
                    <div class="card-header-custom">
                        <h5 class="mb-0">
                            <i class="fas fa-bolt me-2 text-warning"></i>
                            Quick Actions
                        </h5>
                    </div>
                    <div class="card-body-custom">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <a href="{{ route('semesters.create') }}" class="quick-action-btn quick-action-purple">
                                    <div class="action-icon">
                                        <i class="fas fa-calendar-plus"></i>
                                    </div>
                                    <span>Add Semester</span>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('courses.create') }}" class="quick-action-btn quick-action-green">
                                    <div class="action-icon">
                                        <i class="fas fa-book-medical"></i>
                                    </div>
                                    <span>Add Course</span>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('grades.create') }}" class="quick-action-btn quick-action-blue">
                                    <div class="action-icon">
                                        <i class="fas fa-plus-circle"></i>
                                    </div>
                                    <span>Add Grade</span>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('tasks.create') }}" class="quick-action-btn quick-action-orange">
                                    <div class="action-icon">
                                        <i class="fas fa-clipboard-list"></i>
                                    </div>
                                    <span>Add Task</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>

.dashboard-wrapper {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
    padding-bottom: 40px;
}

.welcome-header {
    background: linear-gradient(135deg, #764ba2 0%, #764ba2 100%);
    padding: 40px 0;
    margin-bottom: 40px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.welcome-title {
    color: white;
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 10px;
    text-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.welcome-subtitle {
    color: rgba(255,255,255,0.9);
    font-size: 1.1rem;
    margin: 0;
}

.stats-row {
    margin-top: -60px;
}

.stat-card {
    position: relative;
    border-radius: 20px;
    padding: 30px;
    color: white;
    overflow: hidden;
    transition: all 0.3s;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.stat-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.25);
}

.stat-card-gradient-purple {
    background: linear-gradient(135deg, #764ba2 0%, #764ba2 100%);
}

.stat-card-gradient-pink {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.stat-card-gradient-blue {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.stat-card-gradient-orange {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

.stat-content {
    position: relative;
    z-index: 2;
}

.stat-label {
    font-size: 14px;
    opacity: 0.9;
    margin-bottom: 10px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-value {
    font-size: 3rem;
    font-weight: 800;
    margin: 0;
    text-shadow: 0 2px 10px rgba(0,0,0,0.2);
}

.stat-icon {
    position: absolute;
    right: 30px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 4rem;
    opacity: 0.2;
    z-index: 1;
}

.stat-bg-decoration {
    position: absolute;
    width: 200px;
    height: 200px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    right: -50px;
    top: -50px;
    z-index: 0;
}

.modern-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
    overflow: hidden;
    transition: all 0.3s;
}

.modern-card:hover {
    box-shadow: 0 10px 30px rgba(0,0,0,0.12);
}

.card-header-custom {
    padding: 25px 30px;
    border-bottom: 2px solid #f0f0f0;
    background: linear-gradient(to right, #fafafa, #ffffff);
}

.card-header-custom h5 {
    font-weight: 700;
    color: #2d3748;
    margin: 0;
    font-size: 1.2rem;
}

.card-body-custom {
    padding: 30px;
}

.modern-table {
    margin: 0;
}

.modern-table thead th {
    border: none;
    color: #6c757d;
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 15px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.modern-table tbody td {
    border: none;
    padding: 20px 15px;
    vertical-align: middle;
    border-bottom: 1px solid #f0f0f0;
}

.modern-table tbody tr:last-child td {
    border-bottom: none;
}

.modern-table tbody tr {
    transition: all 0.3s;
}

.modern-table tbody tr:hover {
    background: linear-gradient(to right, #f8f9fa, #ffffff);
    transform: scale(1.01);
}

.course-info strong {
    color: #2d3748;
    font-size: 15px;
}

.grade-point {
    font-weight: 700;
    color: #764ba2;
    font-size: 16px;
}
.badge-grade {
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.tasks-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.task-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border-radius: 15px;
    border-left: 4px solid transparent;
    transition: all 0.3s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.task-item:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.task-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    flex-shrink: 0;
}

.task-indicator-high {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    box-shadow: 0 0 10px rgba(239, 68, 68, 0.5);
}

.task-indicator-medium {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    box-shadow: 0 0 10px rgba(245, 158, 11, 0.5);
}

.task-indicator-low {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
}

.task-content {
    flex-grow: 1;
}

.task-content h6 {
    font-size: 15px;
    font-weight: 600;
    margin: 0 0 5px 0;
    color: #2d3748;
}

.task-content small {
    font-size: 13px;
    color: #6c757d;
}

.badge-priority {
    padding: 6px 12px;
    border-radius: 10px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-priority-high {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #dc2626;
}

.badge-priority-medium {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #d97706;
}

.badge-priority-low {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: #2563eb;
}

.quick-action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 15px;
    padding: 30px 20px;
    background: white;
    border: 2px solid #e9ecef;
    border-radius: 16px;
    text-decoration: none;
    color: #2d3748;
    font-weight: 600;
    transition: all 0.3s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.quick-action-btn:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    color: white;
}

.action-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    transition: all 0.3s;
}

.quick-action-purple:hover {
    background: linear-gradient(135deg, #764ba2, #764ba2);
    border-color: transparent;
}

.quick-action-purple:hover .action-icon {
    background: rgba(255,255,255,0.2);
    color: white;
}

.quick-action-green:hover {
    background: linear-gradient(135deg, #10b981, #059669);
    border-color: transparent;
}

.quick-action-green:hover .action-icon {
    background: rgba(255,255,255,0.2);
    color: white;
}

.quick-action-blue:hover {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border-color: transparent;
}

.quick-action-blue:hover .action-icon {
    background: rgba(255,255,255,0.2);
    color: white;
}

.quick-action-orange:hover {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    border-color: transparent;
}

.quick-action-orange:hover .action-icon {
    background: rgba(255,255,255,0.2);
    color: white;
}

.quick-action-purple .action-icon {
    background: rgba(102, 126, 234, 0.1);
    color: #764ba2;
}

.quick-action-green .action-icon {
    background: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.quick-action-blue .action-icon {
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
}

.quick-action-orange .action-icon {
    background: rgba(245, 158, 11, 0.1);
    color: #f59e0b;
}

.empty-state {
    text-align: center;
    padding: 60px 30px;
}

.empty-icon {
    font-size: 4rem;
    color: #cbd5e0;
    margin-bottom: 20px;
}

.empty-state h5 {
    color: #2d3748;
    font-weight: 700;
    margin-bottom: 10px;
}

.empty-state p {
    color: #6c757d;
    margin-bottom: 25px;
}

.btn-modern {
    border-radius: 12px;
    padding: 12px 24px;
    font-weight: 600;
    transition: all 0.3s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.btn-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
}

@media (max-width: 768px) {
    .welcome-title {
        font-size: 1.8rem;
    }
    
    .stat-value {
        font-size: 2.2rem;
    }
    
    .stat-icon {
        font-size: 3rem;
        right: 20px;
    }
    
    .stats-row {
        margin-top: -40px;
    }
}
</style>
@endpush