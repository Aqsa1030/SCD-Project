@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <h1 class="fw-bold mb-1">
            <i class="fas fa-tachometer-alt text-primary"></i> Dashboard
        </h1>
        <p class="text-muted mb-0">Welcome back, {{ $user->name }}! Here's your academic overview.</p>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Semesters -->
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-calendar fa-3x text-primary mb-3"></i>
                    <h3 class="fw-bold mb-1">{{ $totalSemesters }}</h3>
                    <p class="text-muted mb-0">Total Semesters</p>
                </div>
            </div>
        </div>

        <!-- Active Semesters -->
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-3x text-success mb-3"></i>
                    <h3 class="fw-bold mb-1">{{ $activeSemesters }}</h3>
                    <p class="text-muted mb-0">Active Semesters</p>
                </div>
            </div>
        </div>

        <!-- Total Courses -->
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-book fa-3x text-info mb-3"></i>
                    <h3 class="fw-bold mb-1">{{ $totalCourses }}</h3>
                    <p class="text-muted mb-0">Total Courses</p>
                </div>
            </div>
        </div>

        <!-- Overall GPA -->
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-star fa-3x text-warning mb-3"></i>
                    <h3 class="fw-bold mb-1">{{ number_format($overallGPA, 2) }}</h3>
                    <p class="text-muted mb-0">Overall GPA</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row Stats -->
    <div class="row g-4 mb-4">
        <!-- Total Grades -->
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-chart-bar fa-3x text-purple mb-3" style="color: #667eea;"></i>
                    <h3 class="fw-bold mb-1">{{ $totalGrades }}</h3>
                    <p class="text-muted mb-0">Total Grades</p>
                </div>
            </div>
        </div>

        <!-- Pending Tasks -->
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-tasks fa-3x text-danger mb-3"></i>
                    <h3 class="fw-bold mb-1">{{ $pendingTasks }}</h3>
                    <p class="text-muted mb-0">Pending Tasks</p>
                </div>
            </div>
        </div>

        <!-- Completed Tasks -->
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <h3 class="fw-bold mb-1">{{ $completedTasks }}</h3>
                    <p class="text-muted mb-0">Completed Tasks</p>
                </div>
            </div>
        </div>

        <!-- Average Attendance -->
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-check fa-3x text-info mb-3"></i>
                    <h3 class="fw-bold mb-1">{{ number_format($averageAttendance, 1) }}%</h3>
                    <p class="text-muted mb-0">Avg Attendance</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <!-- Recent Grades -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line me-2 text-primary"></i>Recent Grades
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentGrades->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentGrades as $grade)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $grade->title }}</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-book"></i> {{ $grade->course->name }}
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-primary">{{ $grade->percentage }}%</span>
                                        <br>
                                        <small class="text-muted">{{ $grade->letter_grade }}</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('grades.index') }}" class="btn btn-primary btn-sm">
                                View All Grades
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No grades recorded yet</p>
                            <a href="{{ route('grades.create') }}" class="btn btn-primary btn-sm">
                                Add Grade
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Tasks -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-tasks me-2 text-primary"></i>Recent Tasks
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentTasks->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentTasks as $task)
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $task->title }}</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar"></i> Due: {{ $task->due_date->format('M d, Y') }}
                                        </small>
                                    </div>
                                    <div>
                                        @if($task->status === 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($task->status === 'in_progress')
                                            <span class="badge bg-warning">In Progress</span>
                                        @else
                                            <span class="badge bg-danger">Pending</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('tasks.index') }}" class="btn btn-primary btn-sm">
                                View All Tasks
                            </a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No tasks created yet</p>
                            <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">
                                Add Task
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2 text-primary"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('semesters.create') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-plus-circle"></i> Add Semester
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('courses.create') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-plus-circle"></i> Add Course
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('grades.create') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-plus-circle"></i> Add Grade
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('tasks.create') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-plus-circle"></i> Add Task
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection