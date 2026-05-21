@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">
                <i class="fas fa-tasks text-primary"></i> My Tasks
            </h1>
            <p class="text-muted mb-0">Manage your assignments and to-do items</p>
        </div>
        <div>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Task
            </a>
        </div>
    </div>

    <!-- Task Statistics -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card stat-card text-center">
                <div class="card-body">
                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                    <h3>{{ $pendingTasks->count() }}</h3>
                    <small class="text-muted">Pending Tasks</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card text-center" style="border-left-color: #4cc9f0;">
                <div class="card-body">
                    <i class="fas fa-spinner fa-2x text-primary mb-2"></i>
                    <h3>{{ $inProgressTasks->count() }}</h3>
                    <small class="text-muted">In Progress</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card text-center" style="border-left-color: #06d6a0;">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h3>{{ $completedTasks->count() }}</h3>
                    <small class="text-muted">Completed</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks DataTable -->
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-transparent border-0 pt-4 pb-3">
            <h4 class="mb-0 fw-bold">
                <i class="fas fa-table me-2 text-primary"></i>All Tasks
            </h4>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="tasksTable" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Course</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Progress</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingTasks->merge($inProgressTasks)->merge($completedTasks) as $task)
                        <tr class="{{ $task->isOverdue() ? 'table-danger' : '' }}">
                            <td>
                                <div>
                                    <strong>{{ $task->title }}</strong>
                                    @if($task->description)
                                    <br>
                                    <small class="text-muted">{{ Str::limit($task->description, 50) }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($task->course)
                                    <span class="badge bg-secondary">{{ $task->course->course_code }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $task->getPriorityBadgeClass() }}">
                                    @if($task->priority == 'high')
                                        🔴 High
                                    @elseif($task->priority == 'medium')
                                        🟡 Medium
                                    @else
                                        🟢 Low
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $task->status == 'completed' ? 'success' : ($task->status == 'in_progress' ? 'primary' : 'warning') }}">
                                    @if($task->status == 'pending')
                                        ⏳ Pending
                                    @elseif($task->status == 'in_progress')
                                        🔄 In Progress
                                    @else
                                        ✅ Completed
                                    @endif
                                </span>
                            </td>
                            <td data-order="{{ $task->due_date->format('Y-m-d') }}">
                                <div>
                                    {{ $task->due_date->format('M d, Y') }}
                                    @if($task->due_time)
                                        <br><small class="text-muted">{{ \Carbon\Carbon::parse($task->due_time)->format('h:i A') }}</small>
                                    @endif
                                    @if($task->isOverdue())
                                        <br><span class="badge bg-danger">Overdue!</span>
                                    @endif
                                </div>
                            </td>
                            <td data-order="{{ $task->progress }}">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height: 8px;">
                                        <div class="progress-bar" style="width: {{ $task->progress }}%"></div>
                                    </div>
                                    <small class="text-muted">{{ $task->progress }}%</small>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($task->status != 'completed')
                                    <form action="{{ route('tasks.complete', $task) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" title="Complete">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('tasks.destroy', $task) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Delete this task?');">
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
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#tasksTable').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[4, 'asc']], // Sort by due date (earliest first)
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel me-1"></i> Excel',
                titleAttr: 'Export to Excel',
                className: 'btn-success',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf me-1"></i> PDF',
                titleAttr: 'Export to PDF',
                className: 'btn-danger',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print me-1"></i> Print',
                titleAttr: 'Print Table',
                className: 'btn-info',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
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
            searchPlaceholder: "Search tasks...",
            lengthMenu: "Show _MENU_ tasks per page",
            info: "Showing _START_ to _END_ of _TOTAL_ tasks",
            infoEmpty: "No tasks available",
            infoFiltered: "(filtered from _MAX_ total tasks)",
            zeroRecords: "No matching tasks found",
            emptyTable: "No tasks available",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        },
        columnDefs: [
            { targets: [6], orderable: false } 
        ]
    });
});
</script>
@endpush