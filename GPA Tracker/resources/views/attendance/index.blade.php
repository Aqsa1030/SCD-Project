@extends('layouts.app')

@section('title', 'Attendance')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">
                <i class="fas fa-calendar-check text-primary"></i> Attendance Tracker
            </h1>
            <p class="text-muted mb-0">Monitor your class attendance and statistics</p>
        </div>
        <div>
            <a href="{{ route('attendance.report') }}" class="btn btn-info me-2">
                <i class="fas fa-chart-bar"></i> View Report
            </a>
            <a href="{{ route('attendance.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Mark Attendance
            </a>
        </div>
    </div>
    @if($courses->count() > 0)
    <div class="row g-4 mb-4">
        @foreach($courses as $course)
        @php
            $totalClasses = $course->attendances->count();
            $presentClasses = $course->attendances->whereIn('status', ['present', 'late'])->count();
            $absentClasses = $course->attendances->where('status', 'absent')->count();
            $percentage = $totalClasses > 0 ? round(($presentClasses / $totalClasses) * 100, 2) : 0;
        @endphp
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm" style="border-radius: 15px; border-left: 5px solid {{ $course->color_code }};">
                <div class="card-header" style="background: {{ $course->color_code }}; color: white; border-radius: 15px 15px 0 0;">
                    <h6 class="mb-0 fw-bold">{{ $course->course_name }}</h6>
                    <small>{{ $course->course_code }}</small>
                </div>
                <div class="card-body">
              
                    <div class="text-center mb-3">
                        <h2 class="mb-1 fw-bold text-{{ $percentage >= 75 ? 'success' : 'danger' }}">
                            {{ number_format($percentage, 1) }}%
                        </h2>
                        <p class="text-muted mb-0">Attendance Rate</p>
                    </div>

                    <div class="progress mb-3" style="height: 12px; border-radius: 10px;">
                        <div class="progress-bar bg-{{ $percentage >= 75 ? 'success' : 'danger' }}" 
                             style="width: {{ $percentage }}%">
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="col-4">
                            <small class="text-muted d-block">Total</small>
                            <strong class="fs-5">{{ $totalClasses }}</strong>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block">Present</small>
                            <strong class="fs-5 text-success">{{ $presentClasses }}</strong>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block">Absent</small>
                            <strong class="fs-5 text-danger">{{ $absentClasses }}</strong>
                        </div>
                    </div>

                    @if($percentage < 75)
                    <div class="alert alert-warning mt-3 mb-0 py-2" style="border-radius: 10px;">
                        <small>
                            <i class="fas fa-exclamation-triangle"></i>
                            Low attendance! Need {{ ceil((0.75 * ($totalClasses + 1)) - $presentClasses) }} more present day(s)
                        </small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-transparent border-0 pt-4 pb-3">
            <h4 class="mb-0 fw-bold">
                <i class="fas fa-history me-2 text-primary"></i>Recent Attendance
            </h4>
        </div>
        <div class="card-body p-4">
            @if($recentAttendances->count() > 0)
            <div class="table-responsive">
                <table id="attendanceTable" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Course</th>
                            <th>Status</th>
                            <th>Time</th>
                            <th>Remarks</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentAttendances as $attendance)
                        <tr>
                            <td data-order="{{ $attendance->date->format('Y-m-d') }}">
                                <div>
                                    <strong>{{ $attendance->date->format('M d, Y') }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $attendance->date->format('l') }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width: 8px; height: 40px; background: {{ $attendance->course->color_code }}; border-radius: 4px;"></div>
                                    <div>
                                        <strong>{{ $attendance->course->course_name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $attendance->course->course_code }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $attendance->getStatusBadgeClass() }} px-3 py-2">
                                    <i class="fas {{ $attendance->getStatusIcon() }} me-1"></i>
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>
                            <td>
                                @if($attendance->time)
                                    <i class="fas fa-clock me-1 text-muted"></i>
                                    {{ \Carbon\Carbon::parse($attendance->time)->format('h:i A') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($attendance->remarks)
                                    <span class="text-muted">{{ Str::limit($attendance->remarks, 40) }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('attendance.edit', $attendance) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('attendance.destroy', $attendance) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this attendance record?');">
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
            @else
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">No attendance records yet</h5>
                <p class="text-muted mb-4">Start tracking your attendance</p>
                <a href="{{ route('attendance.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Mark Attendance
                </a>
            </div>
            @endif
        </div>
    </div>
    @else
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body text-center py-5">
            <i class="fas fa-book-open fa-4x text-muted mb-4" style="opacity: 0.3;"></i>
            <h4 class="mb-3 fw-bold">No Active Courses</h4>
            <p class="text-muted mb-4">Add courses first to start tracking attendance.</p>
            <a href="{{ route('courses.create') }}" class="btn btn-primary btn-lg" style="border-radius: 10px;">
                <i class="fas fa-plus me-2"></i>Add Course
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.stat-card {
    border-left: 5px solid #667eea;
    transition: all 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#attendanceTable').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[0, 'desc']], 
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel me-1"></i> Excel',
                titleAttr: 'Export to Excel',
                className: 'btn-success',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf me-1"></i> PDF',
                titleAttr: 'Export to PDF',
                className: 'btn-danger',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                },
                customize: function(doc) {
                    doc.content[1].table.widths = ['20%', '25%', '15%', '15%', '25%'];
                }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print me-1"></i> Print',
                titleAttr: 'Print Table',
                className: 'btn-info',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'colvis',
                text: '<i class="fas fa-columns me-1"></i> Columns',
                titleAttr: 'Column Visibility'
            }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search attendance...",
            lengthMenu: "Show _MENU_ records per page",
            info: "Showing _START_ to _END_ of _TOTAL_ records",
            infoEmpty: "No records available",
            infoFiltered: "(filtered from _MAX_ total records)",
            zeroRecords: "No matching records found",
            emptyTable: "No attendance records available",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        },
        columnDefs: [
            { targets: [5], orderable: false } 
        ]
    });
});
</script>
@endpush