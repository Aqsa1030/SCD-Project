@extends('layouts.app')

@section('title', 'Progress Report')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">
                <i class="fas fa-chart-bar text-primary"></i> Progress Report
            </h1>
            <p class="text-muted mb-0">{{ $activeSemester->name }} - Detailed Progress Analysis</p>
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Print Report
            </button>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="card stat-card text-center">
                        <div class="card-body">
                            <i class="fas fa-chart-line fa-3x text-primary mb-3"></i>
                            <h2 class="mb-1">{{ number_format($activeSemester->achieved_gpa ?? 0, 2) }}</h2>
                            <p class="text-muted mb-0">Current GPA</p>
                            @if($activeSemester->target_gpa)
                            <small class="text-muted">Target: {{ number_format($activeSemester->target_gpa, 2) }}</small>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card text-center" style="border-left-color: #06d6a0;">
                        <div class="card-body">
                            <i class="fas fa-book fa-3x text-success mb-3"></i>
                            <h2 class="mb-1">{{ $activeSemester->courses->count() }}</h2>
                            <p class="text-muted mb-0">Total Courses</p>
                            <small class="text-muted">{{ $activeSemester->getTotalCredits() }} Credits</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card text-center" style="border-left-color: #4cc9f0;">
                        <div class="card-body">
                            <i class="fas fa-tasks fa-3x text-info mb-3"></i>
                            <h2 class="mb-1">{{ number_format($progressPercentage, 0) }}%</h2>
                            <p class="text-muted mb-0">Completion</p>
                            <div class="progress mt-2" style="height: 8px;">
                                <div class="progress-bar" style="width: {{ $progressPercentage }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card text-center" style="border-left-color: #ffd60a;">
                        <div class="card-body">
                            <i class="fas fa-calendar-check fa-3x text-warning mb-3"></i>
                            <h2 class="mb-1">
                                @php
                                    $avgAttendance = $activeSemester->courses->avg(function($course) {
                                        return $course->attendancePercentage();
                                    });
                                @endphp
                                {{ number_format($avgAttendance, 0) }}%
                            </h2>
                            <p class="text-muted mb-0">Avg Attendance</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Course Performance Details</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Credits</th>
                                    <th>Current Grade</th>
                                    <th>Target</th>
                                    <th>Attendance</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activeSemester->courses as $course)
                                <tr>
                                    <td>
                                        <strong>{{ $course->course_name }}</strong><br>
                                        <small class="text-muted">{{ $course->course_code }}</small>
                                    </td>
                                    <td>{{ $course->credit_hours }}</td>
                                    <td>
                                        @if($course->current_grade)
                                            <span class="grade-{{ str_replace('+', '\+', str_replace('-', '-', $course->getLetterGrade())) }}">
                                                {{ number_format($course->current_grade, 1) }}%
                                            </span>
                                            <br>
                                            <small class="badge bg-{{ $course->getGradeColorClass() }}">
                                                {{ $course->getLetterGrade() }}
                                            </small>
                                        @else
                                            <span class="text-muted">Not graded</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $course->target_grade ? number_format($course->target_grade, 0) . '%' : 'N/A' }}
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 8px; width: 80px;">
                                            <div class="progress-bar bg-{{ $course->attendancePercentage() >= 75 ? 'success' : 'danger' }}" 
                                                 style="width: {{ $course->attendancePercentage() }}%">
                                            </div>
                                        </div>
                                        <small>{{ number_format($course->attendancePercentage(), 0) }}%</small>
                                    </td>
                                    <td>
                                        @if($course->current_grade)
                                            @if($course->current_grade >= 85)
                                                <span class="badge bg-success">Excellent</span>
                                            @elseif($course->current_grade >= 70)
                                                <span class="badge bg-primary">Good</span>
                                            @elseif($course->current_grade >= 60)
                                                <span class="badge bg-warning">Fair</span>
                                            @else
                                                <span class="badge bg-danger">Needs Work</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">In Progress</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-chart-pie"></i> Grade Distribution</h6>
                </div>
                <div class="card-body">
                    <canvas id="gradeChart"></canvas>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="fas fa-trophy"></i> Achievements</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        @if($activeSemester->achieved_gpa >= 3.5)
                        <li class="mb-2">
                            <i class="fas fa-star text-warning me-2"></i>
                            Dean's List Candidate
                        </li>
                        @endif
                        @if($avgAttendance >= 90)
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Perfect Attendance
                        </li>
                        @endif
                        @if($progressPercentage >= 75)
                        <li class="mb-2">
                            <i class="fas fa-fire text-danger me-2"></i>
                            On Track
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const ctx = document.getElementById('gradeChart');
if(ctx) {
    const grades = {!! json_encode($activeSemester->courses->pluck('current_grade')->filter()) !!};
    const distribution = { 'A': 0, 'B': 0, 'C': 0, 'D': 0, 'F': 0 };
    
    grades.forEach(grade => {
        if(grade >= 80) distribution.A++;
        else if(grade >= 70) distribution.B++;
        else if(grade >= 60) distribution.C++;
        else if(grade >= 50) distribution.D++;
        else distribution.F++;
    });
    
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['A', 'B', 'C', 'D', 'F'],
            datasets: [{
                data: Object.values(distribution),
                backgroundColor: ['#28a745', '#007bff', '#ffc107', '#fd7e14', '#dc3545']
            }]
        }
    });
}
</script>
@endsection