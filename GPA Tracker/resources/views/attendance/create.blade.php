@extends('layouts.app')

@section('title', 'Mark Attendance')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="mb-4">
        <h1 class="fw-bold mb-1">
            <i class="fas fa-plus-circle text-primary"></i> Mark Attendance
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('attendance.index') }}">Attendance</a></li>
                <li class="breadcrumb-item active">Mark</li>
            </ol>
        </nav>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-check-circle"></i> Attendance Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('attendance.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="course_id" class="form-label">Course <span class="text-danger">*</span></label>
                            <select class="form-select @error('course_id') is-invalid @enderror" 
                                    id="course_id" 
                                    name="course_id" 
                                    required>
                                <option value="">Select Course...</option>
                                @foreach($courses as $course)
                                <option value="{{ $course->id }}" 
                                        {{ old('course_id', request('course_id')) == $course->id ? 'selected' : '' }}>
                                    {{ $course->course_code }} - {{ $course->course_name }}
                                </option>
                                @endforeach
                            </select>
                            @error('course_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control @error('date') is-invalid @enderror" 
                                       id="date" 
                                       name="date" 
                                       value="{{ old('date', date('Y-m-d')) }}" 
                                       max="{{ date('Y-m-d') }}"
                                       required>
                                @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="time" class="form-label">Time</label>
                                <input type="time" 
                                       class="form-control @error('time') is-invalid @enderror" 
                                       id="time" 
                                       name="time" 
                                       value="{{ old('time', date('H:i')) }}">
                                @error('time')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline w-100">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="status" 
                                               id="present" 
                                               value="present" 
                                               {{ old('status', 'present') == 'present' ? 'checked' : '' }}
                                               required>
                                        <label class="form-check-label w-100" for="present">
                                            <div class="card mb-0">
                                                <div class="card-body text-center py-3">
                                                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                                    <h6 class="mb-0">Present</h6>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline w-100">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="status" 
                                               id="absent" 
                                               value="absent" 
                                               {{ old('status') == 'absent' ? 'checked' : '' }}>
                                        <label class="form-check-label w-100" for="absent">
                                            <div class="card mb-0">
                                                <div class="card-body text-center py-3">
                                                    <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                                                    <h6 class="mb-0">Absent</h6>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline w-100">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="status" 
                                               id="late" 
                                               value="late" 
                                               {{ old('status') == 'late' ? 'checked' : '' }}>
                                        <label class="form-check-label w-100" for="late">
                                            <div class="card mb-0">
                                                <div class="card-body text-center py-3">
                                                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                                                    <h6 class="mb-0">Late</h6>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline w-100">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="status" 
                                               id="excused" 
                                               value="excused" 
                                               {{ old('status') == 'excused' ? 'checked' : '' }}>
                                        <label class="form-check-label w-100" for="excused">
                                            <div class="card mb-0">
                                                <div class="card-body text-center py-3">
                                                    <i class="fas fa-info-circle fa-2x text-info mb-2"></i>
                                                    <h6 class="mb-0">Excused</h6>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('status')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control @error('remarks') is-invalid @enderror" 
                                      id="remarks" 
                                      name="remarks" 
                                      rows="3" 
                                      placeholder="Any additional notes or reason...">{{ old('remarks') }}</textarea>
                            @error('remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('attendance.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Mark Attendance
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-info-circle"></i> Quick Guide</h6>
                </div>
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Status Definitions:</h6>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Present:</strong> Attended the full class
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-times-circle text-danger me-2"></i>
                            <strong>Absent:</strong> Did not attend
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-clock text-warning me-2"></i>
                            <strong>Late:</strong> Arrived after class started
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-info-circle text-info me-2"></i>
                            <strong>Excused:</strong> Pre-approved absence
                        </li>
                    </ul>

                    <div class="alert alert-warning mb-0">
                        <small>
                            <i class="fas fa-lightbulb"></i>
                            <strong>Tip:</strong> Maintain at least 75% attendance for most courses
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection