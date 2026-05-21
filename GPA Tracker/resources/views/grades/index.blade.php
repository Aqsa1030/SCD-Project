@extends('layouts.app')

@section('title', 'Grades')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="text-white">
                            <h2 class="fw-bold mb-2">
                                <i class="fas fa-chart-line me-2"></i>My Grades
                            </h2>
                            <p class="mb-0 opacity-90">Track and manage all your assessment grades</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('grades.calculator') }}" class="btn btn-light btn-lg">
                                <i class="fas fa-calculator me-2"></i>GPA Calculator
                            </a>
                            <a href="{{ route('grades.create') }}" class="btn btn-warning btn-lg">
                                <i class="fas fa-plus me-2"></i>Add Grade
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($grades->count() > 0)
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <div class="card-body text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 opacity-90">Total Grades</h6>
                                <h2 class="fw-bold mb-0">{{ $grades->total() }}</h2>
                            </div>
                            <div class="fs-1 opacity-75">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <div class="card-body text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 opacity-90">Graded</h6>
                                <h2 class="fw-bold mb-0">{{ $grades->where('status', 'graded')->count() }}</h2>
                            </div>
                            <div class="fs-1 opacity-75">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                    <div class="card-body text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 opacity-90">Pending</h6>
                                <h2 class="fw-bold mb-0">{{ $grades->where('status', 'pending')->count() }}</h2>
                            </div>
                            <div class="fs-1 opacity-75">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
                    <div class="card-body text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 opacity-90">Average</h6>
                                <h2 class="fw-bold mb-0">
                                    @php
                                        $gradedGrades = $grades->where('percentage', '!=', null);
                                        $average = $gradedGrades->count() > 0 ? $gradedGrades->avg('percentage') : 0;
                                    @endphp
                                    {{ number_format($average, 1) }}%
                                </h2>
                            </div>
                            <div class="fs-1 opacity-75">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-transparent border-0 pt-4 pb-3">
                <h4 class="mb-0 fw-bold">
                    <i class="fas fa-table me-2 text-primary"></i>All Grades
                </h4>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="gradesTable" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Course</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Weightage</th>
                                <th>Score</th>
                                <th>Percentage</th>
                                <th>Grade</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grades as $grade)
                            <tr>
                                <td>
                                    <strong>{{ $grade->title }}</strong>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $grade->course->course_name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $grade->course->course_code }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $grade->assessment_type }}</span>
                                </td>
                                <td data-order="{{ $grade->date->format('Y-m-d') }}">
                                    {{ $grade->date->format('M d, Y') }}
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $grade->weightage }}%</span>
                                </td>
                                <td>
                                    @if($grade->marks_obtained !== null)
                                        <strong>{{ $grade->marks_obtained }}</strong>/{{ $grade->total_marks }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td data-order="{{ $grade->percentage ?? 0 }}">
                                    @if($grade->percentage !== null)
                                        <strong class="text-primary">{{ number_format($grade->percentage, 1) }}%</strong>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($grade->letter_grade && $grade->letter_grade != 'N/A')
                                        <span class="badge bg-success">{{ $grade->letter_grade }}</span>
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
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('grades.edit', $grade) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('grades.destroy', $grade) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Delete this grade?');">
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
        </div>

    @else
        
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-body text-center py-5">
                        <div class="mb-4" style="font-size: 80px; opacity: 0.3;">
                            📊
                        </div>
                        <h3 class="fw-bold mb-3">No Grades Yet</h3>
                        <p class="text-muted mb-4">Start tracking your academic performance by adding your first grade.</p>
                        <a href="{{ route('grades.create') }}" class="btn btn-lg btn-primary" style="border-radius: 10px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                            <i class="fas fa-plus me-2"></i>Add Your First Grade
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#gradesTable').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[3, 'desc']], 
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel me-1"></i> Excel',
                titleAttr: 'Export to Excel',
                className: 'btn-success',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8] 
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf me-1"></i> PDF',
                titleAttr: 'Export to PDF',
                className: 'btn-danger',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print me-1"></i> Print',
                titleAttr: 'Print Table',
                className: 'btn-info',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
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
            searchPlaceholder: "Search grades...",
            lengthMenu: "Show _MENU_ grades per page",
            info: "Showing _START_ to _END_ of _TOTAL_ grades",
            infoEmpty: "No grades available",
            infoFiltered: "(filtered from _MAX_ total grades)",
            zeroRecords: "No matching grades found",
            emptyTable: "No grades available",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        },
        columnDefs: [
            { targets: [9], orderable: false } 
        ]
    });
});
</script>
@endpush