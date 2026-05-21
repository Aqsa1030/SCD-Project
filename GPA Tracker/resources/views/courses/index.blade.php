@extends('layouts.app')

@section('title', 'Courses')

@section('content')
<div class="courses-page-full">
    <div class="page-header-gradient">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-title">
                        <i class="fas fa-book me-3"></i>
                        My Courses
                    </h1>
                    <p class="display-subtitle">Manage and track all your courses, grades, and attendance</p>
                </div>
                <div class="col-lg-6 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('courses.create') }}" class="btn-add-main">
                        <i class="fas fa-plus-circle me-2"></i>
                        Add Course
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-area">
        <div class="container">
            @if($courses->count() > 0)
            <div class="stats-summary-grid mb-5">
                <div class="stat-card purple-gradient">
                    <div class="stat-content">
                        <h3>{{ $courses->count() }}</h3>
                        <p>Total Courses</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
                <div class="stat-card blue-gradient">
                    <div class="stat-content">
                        @php
                            $gradesSum = 0;
                            $gradesCount = 0;
                            foreach($courses as $c) {
                                if ($c->current_grade) {
                                    $gradesSum += $c->current_grade;
                                    $gradesCount++;
                                }
                            }
                            $avgGrade = $gradesCount > 0 ? round($gradesSum / $gradesCount, 1) : 0;
                        @endphp
                        <h3>{{ number_format($avgGrade, 1) }}%</h3>
                        <p>Average Grade</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
                <div class="stat-card green-gradient">
                    <div class="stat-content">
                        @php
                            $totalCredits = $courses->sum('credits');
                        @endphp
                        <h3>{{ $totalCredits }}</h3>
                        <p>Total Credit Hours</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                </div>
                <div class="stat-card orange-gradient">
                    <div class="stat-content">
                        @php
                            $totalAttendance = 0;
                            $attendanceCount = 0;
                            foreach($courses as $c) {
                                $attendance = $c->calculateAttendancePercentage();
                                if ($attendance > 0) {
                                    $totalAttendance += $attendance;
                                    $attendanceCount++;
                                }
                            }
                            $avgAttendance = $attendanceCount > 0 ? round($totalAttendance / $attendanceCount, 1) : 0;
                        @endphp
                        <h3>{{ number_format($avgAttendance, 1) }}%</h3>
                        <p>Avg Attendance</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                </div>
            </div>

            <div class="courses-table-container">
                <div class="table-header-section">
                    <h3 class="table-title">
                        <i class="fas fa-table me-2"></i>All Courses
                    </h3>
                </div>

                <div class="table-responsive p-4">
                    <table id="coursesTable" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Code</th>
                                <th>Semester</th>
                                <th>Credits</th>
                                <th>Grade</th>
                                <th>Attendance</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $course)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="course-color" style="width:40px;height:40px;background:{{ $course->color_code }};border-radius:10px;"></div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $course->name }}</h6>
                                            @if($course->instructor)
                                            <small class="text-muted">
                                                <i class="fas fa-user-tie"></i> {{ $course->instructor }}
                                            </small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $course->code }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        <i class="fas fa-calendar me-1"></i>{{ $course->semester->name }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-success">{{ $course->credits }} CH</span>
                                </td>
                                <td>
                                    @if($course->current_grade)
                                        <div>
                                            <strong>{{ number_format($course->current_grade, 1) }}%</strong>
                                            <br>
                                            <span class="badge bg-{{ $course->getGradeColorClass() == 'success' ? 'success' : ($course->getGradeColorClass() == 'warning' ? 'warning' : 'danger') }}">
                                                {{ $course->getLetterGrade() }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-muted">Not graded</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $attendancePercent = $course->calculateAttendancePercentage();
                                    @endphp
                                    <div>
                                        <strong class="text-{{ $attendancePercent >= 75 ? 'success' : 'danger' }}">
                                            {{ number_format($attendancePercent, 0) }}%
                                        </strong>
                                        <div class="progress mt-1" style="height:6px;">
                                            <div class="progress-bar bg-{{ $attendancePercent >= 75 ? 'success' : 'danger' }}" 
                                                 style="width:{{ $attendancePercent }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('courses.edit', $course) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('courses.destroy', $course) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Delete this course?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
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
            </div>
            @else
            <div class="empty-state-centered">
                <div class="empty-icon-wrapper">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3 class="empty-heading">No Courses Yet</h3>
                <p class="empty-description">Add your first course to start tracking grades and attendance</p>
                <a href="{{ route('courses.create') }}" class="btn-create-empty">
                    <i class="fas fa-plus-circle me-2"></i>
                    Add Your First Course
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>

.courses-page-full {
    background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
    min-height: calc(100vh - 56px);
    padding-bottom: 40px;
}

.page-header-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 50px 0;
    box-shadow: 0 8px 32px rgba(0,0,0,0.15);
}

.display-title {
    color: white;
    font-size: 2.8rem;
    font-weight: 900;
    margin-bottom: 12px;
    text-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.display-subtitle {
    color: rgba(255,255,255,0.95);
    font-size: 1.15rem;
    margin: 0;
}

.btn-add-main {
    background: white;
    color: #667eea;
    padding: 16px 40px;
    border-radius: 50px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s;
    box-shadow: 0 8px 24px rgba(0,0,0,0.2);
}

.btn-add-main:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.3);
    color: #667eea;
}

.page-content-area {
    padding: 40px 0;
}

.stats-summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
}

.stat-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    transition: all 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.15);
}

.purple-gradient { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.blue-gradient { background: linear-gradient(135deg, #3b82f6, #2563eb); }
.green-gradient { background: linear-gradient(135deg, #10b981, #059669); }
.orange-gradient { background: linear-gradient(135deg, #f59e0b, #d97706); }

.stat-content h3 {
    color: white;
    font-size: 2.5rem;
    font-weight: 900;
    margin: 0;
}

.stat-content p {
    color: rgba(255,255,255,0.9);
    margin: 10px 0 0 0;
    font-weight: 600;
}

.stat-icon {
    width: 64px;
    height: 64px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 28px;
}

.courses-table-container {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 8px 40px rgba(0,0,0,0.1);
}

.table-header-section {
    padding: 30px;
    border-bottom: 2px solid #e9ecef;
}

.table-title {
    font-size: 1.8rem;
    font-weight: 800;
    color: #2d3748;
    margin: 0;
}

.empty-state-centered {
    background: white;
    border-radius: 32px;
    padding: 100px 60px;
    text-align: center;
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    max-width: 600px;
    margin: 0 auto;
}

.empty-icon-wrapper {
    width: 140px;
    height: 140px;
    margin: 0 auto 40px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 12px 40px rgba(102, 126, 234, 0.3);
}

.empty-icon-wrapper i {
    font-size: 70px;
    color: white;
}

.empty-heading {
    font-size: 2.2rem;
    font-weight: 900;
    color: #2d3748;
    margin-bottom: 16px;
}

.empty-description {
    font-size: 1.1rem;
    color: #6c757d;
    margin-bottom: 40px;
}

.btn-create-empty {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 18px 48px;
    border-radius: 50px;
    font-weight: 700;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s;
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
}

.btn-create-empty:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(102, 126, 234, 0.4);
    color: white;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#coursesTable').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[1, 'asc']], 
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel me-1"></i> Excel',
                titleAttr: 'Export to Excel',
                className: 'btn-success'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf me-1"></i> PDF',
                titleAttr: 'Export to PDF',
                className: 'btn-danger'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print me-1"></i> Print',
                titleAttr: 'Print Table',
                className: 'btn-info'
            },
            {
                extend: 'colvis',
                text: '<i class="fas fa-columns me-1"></i> Columns',
                titleAttr: 'Column Visibility'
            }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search courses...",
            lengthMenu: "Show _MENU_ courses per page",
            info: "Showing _START_ to _END_ of _TOTAL_ courses",
            infoEmpty: "No courses available",
            infoFiltered: "(filtered from _MAX_ total courses)",
            zeroRecords: "No matching courses found",
            emptyTable: "No courses available in table",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        }
    });
});
</script>
@endpush