@extends('layouts.app')

@section('title', $course->course_name)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">
                <span class="rounded-circle d-inline-block me-2" 
                      style="width: 15px; height: 15px; background: {{ $course->color_code }};"></span>
                {{ $course->course_name }}
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Courses</a></li>
                    <li class="breadcrumb-item active">{{ $course->course_code }}</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('courses.edit', $course) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Course
            </a>
            <a href="{{ route('grades.create') }}?course_id={{ $course->id }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Add Grade
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-chart-line fa-2x text-primary mb-2"></i>
                            <h4 class="mb-0">{{ $course->current_grade ? number_format($course->current_grade, 1) . '%' : 'N/A' }}</h4>
                            <small class="text-muted">Current Grade</small>
                        </div>
                    </div>
                </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-medal fa-2x text-success mb-2"></i>
                <h4 class="mb-0">{{ $course->getLetterGrade() }}</h4>
                <small class="text-muted">Letter Grade</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-calendar-check fa-2x text-info mb-2"></i>
                <h4 class="mb-0">{{ number_format($course->calculateAttendancePercentage(), 0) }}%</h4>
                <small class="text-muted">Attendance</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="fas fa-tasks fa-2x text-warning mb-2"></i>
                <h4 class="mb-0">{{ $course->getPendingAssignments() }}</h4>
                <small class="text-muted">Pending</small>
            </div>
        </div>
    </div>
</div>

            <!-- Grades -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Grades & Assessments</h5>
                    <a href="{{ route('grades.create') }}?course_id={{ $course->id }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Add Grade
                    </a>
                </div>
                <div class="card-body">
                    @if($course->grades->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Assessment</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Weight</th>
                                    <th>Score</th>
                                    <th>Grade</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($course->grades as $grade)
                                <tr>
                                    <td><strong>{{ $grade->title }}</strong></td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $grade->assessment_type }}</span>
                                    </td>
                                    <td>{{ $grade->date->format('M d, Y') }}</td>
                                    <td>{{ $grade->weightage }}%</td>
                                    <td>
                                        @if($grade->marks_obtained !== null)
                                            {{ $grade->marks_obtained }}/{{ $grade->total_marks }}
                                        @else
                                            <span class="text-muted">Not graded</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($grade->percentage !== null)
                                            <span class="grade-{{ str_replace('+', '\+', str_replace('-', '-', $grade->letter_grade)) }}">
                                                {{ number_format($grade->percentage, 1) }}%
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $grade->status == 'graded' ? 'success' : ($grade->status == 'completed' ? 'info' : 'warning') }}">
                                            {{ ucfirst($grade->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('grades.edit', $grade) }}" class="btn btn-outline-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('grades.destroy', $grade) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Delete this grade?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No grades recorded yet</p>
                        <a href="{{ route('grades.create') }}?course_id={{ $course->id }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add First Grade
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-calendar-check"></i> Attendance Record</h5>
                    <a href="{{ route('attendance.create') }}?course_id={{ $course->id }}" class="btn btn-sm btn-success">
                        <i class="fas fa-plus"></i> Mark Attendance
                    </a>
                </div>
                <div class="card-body">
                    @if($course->attendances->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Time</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($course->attendances->sortByDesc('date')->take(10) as $attendance)
                                <tr>
                                    <td>{{ $attendance->date->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $attendance->getStatusBadgeClass() }}">
                                            <i class="fas {{ $attendance->getStatusIcon() }}"></i>
                                            {{ ucfirst($attendance->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $attendance->time ? \Carbon\Carbon::parse($attendance->time)->format('h:i A') : '-' }}</td>
                                    <td>{{ $attendance->remarks ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No attendance records yet</p>
                        <a href="{{ route('attendance.create') }}?course_id={{ $course->id }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Mark First Attendance
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-info-circle"></i> Course Details</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Course Code</small>
                        <strong>{{ $course->course_code }}</strong>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Semester</small>
                        <strong>{{ $course->semester->name }}</strong>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Credit Hours</small>
                        <strong>{{ $course->credit_hours }} CH</strong>
                    </div>
                    @if($course->instructor)
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Instructor</small>
                        <strong>{{ $course->instructor }}</strong>
                        @if($course->instructor_email)
                        <br><small><a href="mailto:{{ $course->instructor_email }}">{{ $course->instructor_email }}</a></small>
                        @endif
                    </div>
                    @endif
                    @if($course->schedule)
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Schedule</small>
                        <strong>{{ $course->schedule }}</strong>
                    </div>
                    @endif
                    @if($course->room)
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Room</small>
                        <strong>{{ $course->room }}</strong>
                    </div>
                    @endif
                    @if($course->target_grade)
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Target Grade</small>
                        <strong>{{ $course->target_grade }}%</strong>
                    </div>
                    @endif
                </div>
            </div>

            @if($course->description)
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-align-left"></i> Description</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $course->description }}</p>
                </div>
            </div>
            @endif

            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-sticky-note"></i> Notes</h6>
                </div>
                <div class="card-body">
                    @if($course->notes)
                    <p class="mb-0">{{ $course->notes }}</p>
                    @else
                    <p class="text-muted mb-0">No notes yet</p>
                    @endif
                </div>
            </div>

            @if($course->textbook)
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-book"></i> Textbook</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $course->textbook }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection