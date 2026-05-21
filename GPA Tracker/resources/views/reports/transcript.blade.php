@extends('layouts.app')

@section('title', 'Academic Transcript')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="fas fa-file-alt text-primary"></i> Academic Transcript
            </h1>
            <p class="text-muted mb-0">Complete academic record and performance summary</p>
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-info me-2">
                <i class="fas fa-print"></i> Print
            </button>
            <a href="{{ route('reports.pdf') }}" class="btn btn-danger">
                <i class="fas fa-file-pdf me-2"></i> Download PDF
            </a>
        </div>
    </div>

    <!-- Transcript Card -->
    <div class="card" id="transcript">
        <!-- Header -->
        <div class="card-header text-center py-4" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white;">
            <h2 class="mb-1"><i class="fas fa-graduation-cap"></i> ACADEMIA</h2>
            <h5 class="mb-0">Official Academic Transcript</h5>
        </div>

        <div class="card-body p-5">
            <!-- Student Information -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="fw-bold mb-3">Student Information</h5>
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="40%" class="text-muted">Name:</td>
                            <td><strong>{{ $user->name }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Email:</td>
                            <td><strong>{{ $user->email }}</strong></td>
                        </tr>
                        @if($user->student_id)
                        <tr>
                            <td class="text-muted">Student ID:</td>
                            <td><strong>{{ $user->student_id }}</strong></td>
                        </tr>
                        @endif
                        @if($user->degree)
                        <tr>
                            <td class="text-muted">Program:</td>
                            <td><strong>{{ $user->degree }}</strong></td>
                        </tr>
                        @endif
                        @if($user->department)
                        <tr>
                            <td class="text-muted">Department:</td>
                            <td><strong>{{ $user->department }}</strong></td>
                        </tr>
                        @endif
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="fw-bold mb-3">Academic Summary</h5>
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td width="40%" class="text-muted">Overall GPA:</td>
                            <td><strong class="text-primary fs-5">{{ number_format($overallGPA, 2) }} / 4.0</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Total Credits:</td>
                            <td><strong>{{ $totalCredits }} Credit Hours</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Total Semesters:</td>
                            <td><strong>{{ $semesters->count() }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Issue Date:</td>
                            <td><strong>{{ date('F d, Y') }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr class="my-4">
            @if($semesters->count() > 0)
                @foreach($semesters as $semester)
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-calendar-alt text-primary"></i>
                            {{ $semester->name }} - {{ $semester->year }}
                        </h5>
                        <div>
                            <span class="badge bg-primary me-2">
                                GPA: {{ number_format($semester->semester_gpa ?? 0, 2) }}
                            </span>
                            <span class="badge bg-info">
                                {{ $semester->semester_credits ?? 0 }} Credits
                            </span>
                        </div>
                    </div>

                    @if($semester->courses->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Course Code</th>
                                    <th>Course Name</th>
                                    <th class="text-center">Credits</th>
                                    <th class="text-center">Grade</th>
                                    <th class="text-center">Points</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($semester->courses as $course)
                                @php
                                    // Calculate grade if not set
                                    if (!$course->current_grade || $course->current_grade == 0) {
                                        $course->calculateCurrentGrade();
                                        $course->refresh();
                                    }
                                    $hasGrade = $course->current_grade && $course->current_grade > 0;
                                @endphp
                                <tr>
                                    <td><strong>{{ $course->code }}</strong></td>
                                    <td>{{ $course->name }}</td>
                                    <td class="text-center">{{ $course->credits }}</td>
                                    <td class="text-center">
                                        @if($hasGrade)
                                            @php
                                                $letterGrade = $course->getLetterGrade();
                                                $gradePoint = $course->getGradePoint();
                                                
                                                $badgeClass = 'secondary';
                                                if ($gradePoint >= 3.7) $badgeClass = 'success';
                                                elseif ($gradePoint >= 3.0) $badgeClass = 'primary';
                                                elseif ($gradePoint >= 2.0) $badgeClass = 'warning';
                                                elseif ($gradePoint > 0) $badgeClass = 'danger';
                                            @endphp
                                            <span class="badge bg-{{ $badgeClass }}">
                                                {{ $letterGrade }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">In Progress</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($hasGrade)
                                            <strong>{{ number_format($course->getGradePoint(), 2) }}</strong>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-secondary">
                                <tr>
                                    <td colspan="2" class="text-end"><strong>Semester Totals:</strong></td>
                                    <td class="text-center"><strong>{{ $semester->semester_credits ?? 0 }}</strong></td>
                                    <td class="text-end"><strong>Semester GPA:</strong></td>
                                    <td class="text-center">
                                        <strong class="text-primary">{{ number_format($semester->semester_gpa ?? 0, 2) }}</strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        No courses recorded for this semester.
                    </div>
                    @endif
                </div>
                @endforeach
            @else
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">No Semesters Found</h4>
                <p class="text-muted mb-4">Start by creating your first semester to see your transcript.</p>
                <a href="{{ route('semesters.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i> Create First Semester
                </a>
            </div>
            @endif

            @if($semesters->count() > 0)
            <div class="bg-light p-4 rounded mt-4">
                <div class="row text-center">
                    <div class="col-md-4">
                        <h6 class="text-muted mb-2">Cumulative GPA</h6>
                        <h2 class="text-primary mb-0">{{ number_format($overallGPA, 2) }}</h2>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted mb-2">Total Credits</h6>
                        <h2 class="text-success mb-0">{{ $totalCredits }}</h2>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted mb-2">Academic Standing</h6>
                        <h2 class="mb-0">
                            @if($overallGPA >= 3.5)
                                <span class="text-success">{{ $academicStanding }}</span>
                            @elseif($overallGPA >= 3.0)
                                <span class="text-primary">{{ $academicStanding }}</span>
                            @elseif($overallGPA >= 2.5)
                                <span class="text-warning">{{ $academicStanding }}</span>
                            @else
                                <span class="text-danger">{{ $academicStanding }}</span>
                            @endif
                        </h2>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <h6 class="fw-bold mb-3">Grading Scale Reference</h6>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Letter Grade</th>
                                    <th>Grade Points</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge bg-success">A+</span></td>
                                    <td>4.0</td>
                                    <td>90-100%</td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-success">A</span></td>
                                    <td>4.0</td>
                                    <td>85-89%</td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-success">A-</span></td>
                                    <td>3.7</td>
                                    <td>80-84%</td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-primary">B+</span></td>
                                    <td>3.3</td>
                                    <td>75-79%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Letter Grade</th>
                                    <th>Grade Points</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge bg-primary">B</span></td>
                                    <td>3.0</td>
                                    <td>70-74%</td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-info">B-</span></td>
                                    <td>2.7</td>
                                    <td>65-69%</td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-warning">C</span></td>
                                    <td>2.0</td>
                                    <td>55-64%</td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-danger">D/F</span></td>
                                    <td>1.0/0.0</td>
                                    <td>&lt;55%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="card-footer text-center text-muted">
            <small>
                This is an official transcript generated on {{ date('F d, Y \a\t h:i A') }}<br>
                Generated by Academia GPA Tracker System
            </small>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
@media print {
    .navbar, .sidebar, .btn, nav, .no-print {
        display: none !important;
    }
    .main-content {
        margin-left: 0 !important;
        padding: 0 !important;
    }
    .card {
        box-shadow: none !important;
        border: 1px solid #dee2e6 !important;
    }
    body {
        background: white !important;
    }
}
</style>
@endpush