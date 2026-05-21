@extends('layouts.app')

@section('title', 'Edit Semester')

@section('content')
<div class="container-fluid">
    <div class="card border-0 mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 text-white fw-bold mb-2">
                        <i class="fas fa-edit me-2"></i> Edit Semester
                    </h1>
                    <p class="text-white-50 mb-0">Update semester information and settings</p>
                </div>
                <a href="{{ route('semesters.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left me-2"></i> Back to Semesters
                </a>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Semester Details
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('semesters.update', $semester) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">
                                <i class="fas fa-graduation-cap text-primary me-2"></i>
                                Semester Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $semester->name) }}" 
                                   placeholder="e.g., Fall Semester"
                                   required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="year" class="form-label fw-semibold">
                                <i class="fas fa-calendar-alt text-primary me-2"></i>
                                Academic Year <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('year') is-invalid @enderror" 
                                   id="year" 
                                   name="year" 
                                   value="{{ old('year', $semester->year) }}" 
                                   placeholder="e.g., 2025"
                                   required>
                            @error('year')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label fw-semibold">
                                    <i class="fas fa-play-circle text-success me-2"></i>
                                    Start Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control form-control-lg @error('start_date') is-invalid @enderror" 
                                       id="start_date" 
                                       name="start_date" 
                                       value="{{ old('start_date', $semester->start_date->format('Y-m-d')) }}"
                                       required>
                                @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="end_date" class="form-label fw-semibold">
                                    <i class="fas fa-stop-circle text-danger me-2"></i>
                                    End Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control form-control-lg @error('end_date') is-invalid @enderror" 
                                       id="end_date" 
                                       name="end_date" 
                                       value="{{ old('end_date', $semester->end_date->format('Y-m-d')) }}"
                                       required>
                                @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               role="switch"
                                               id="is_active" 
                                               name="is_active" 
                                               value="1"
                                               style="width: 3rem; height: 1.5rem;"
                                               {{ old('is_active', $semester->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label ms-2 fw-semibold" for="is_active">
                                            <i class="fas fa-star text-warning me-2"></i>
                                            Set as Active Semester
                                        </label>
                                        <p class="text-muted small mb-0 ms-5 ps-2">
                                            The active semester will be used as default for new courses and tasks
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-save me-2"></i> Update Semester
                            </button>
                            <a href="{{ route('semesters.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="fas fa-times me-2"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h6 class="mb-0 text-white fw-bold">
                        <i class="fas fa-info-circle me-2"></i>
                        Current Details
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Semester Name</small>
                        <strong class="d-block">{{ $semester->name }}</strong>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Academic Year</small>
                        <strong class="d-block">{{ $semester->year }}</strong>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Duration</small>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-success">
                                <i class="fas fa-play me-1"></i>
                                {{ $semester->start_date->format('M d, Y') }}
                            </span>
                            <i class="fas fa-arrow-right text-muted"></i>
                            <span class="badge bg-danger">
                                <i class="fas fa-stop me-1"></i>
                                {{ $semester->end_date->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="mb-0">
                        <small class="text-muted d-block mb-1">Status</small>
                        @if($semester->is_active)
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i> Active
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                <i class="fas fa-circle me-1"></i> Inactive
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0 fw-bold">
                        <i class="fas fa-chart-bar text-primary me-2"></i>
                        Semester Statistics
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                             style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="fas fa-book text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">{{ $semester->courses->count() }}</h4>
                            <small class="text-muted">Total Courses</small>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                             style="width: 50px; height: 50px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <i class="fas fa-calendar-check text-white"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold">
                                {{ \Carbon\Carbon::parse($semester->end_date)->diffInDays(\Carbon\Carbon::parse($semester->start_date)) }} Days
                            </h4>
                            <small class="text-muted">Semester Duration</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-2">
                        <i class="fas fa-lightbulb me-2"></i>
                        Quick Tips
                    </h6>
                    <ul class="mb-0 ps-3 small">
                        <li class="mb-2">Only one semester can be active at a time</li>
                        <li class="mb-2">Active semester is used for new courses</li>
                        <li class="mb-0">End date must be after start date</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('semesters.destroy', $semester) }}" 
      method="POST" 
      id="deleteSemesterForm"
      style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('scripts')
<script>
document.getElementById('start_date').addEventListener('change', function() {
    const startDate = new Date(this.value);
    const endDateInput = document.getElementById('end_date');
    const endDate = new Date(endDateInput.value);
    
    if (endDate <= startDate) {
        endDateInput.value = '';
    }
    endDateInput.min = this.value;
});
const startDate = document.getElementById('start_date').value;
if (startDate) {
    document.getElementById('end_date').min = startDate;
}
</script>
@endsection