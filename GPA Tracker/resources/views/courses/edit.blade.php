@extends('layouts.app')

@section('title', 'Edit Course')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h1 class="fw-bold mb-1">
            <i class="fas fa-edit text-primary"></i> Edit Course
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Courses</a></li>
                <li class="breadcrumb-item active">Edit {{ $course->course_code }}</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Update Course Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('courses.update', $course) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="semester_id" class="form-label">Semester <span class="text-danger">*</span></label>
                            <select class="form-select @error('semester_id') is-invalid @enderror" 
                                    id="semester_id" 
                                    name="semester_id" 
                                    required>
                                @foreach($semesters as $semester)
                                <option value="{{ $semester->id }}" 
                                        {{ old('semester_id', $course->semester_id) == $semester->id ? 'selected' : '' }}>
                                    {{ $semester->name }} ({{ $semester->year }})
                                </option>
                                @endforeach
                            </select>
                            @error('semester_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="course_code" class="form-label">Course Code <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('course_code') is-invalid @enderror" 
                                       id="course_code" 
                                       name="course_code" 
                                       value="{{ old('course_code', $course->course_code) }}" 
                                       required>
                                @error('course_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="credit_hours" class="form-label">Credit Hours <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('credit_hours') is-invalid @enderror" 
                                       id="credit_hours" 
                                       name="credit_hours" 
                                       value="{{ old('credit_hours', $course->credit_hours) }}" 
                                       min="1" 
                                       max="6"
                                       required>
                                @error('credit_hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="course_name" class="form-label">Course Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('course_name') is-invalid @enderror" 
                                   id="course_name" 
                                   name="course_name" 
                                   value="{{ old('course_name', $course->course_name) }}" 
                                   required>
                            @error('course_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="instructor" class="form-label">Instructor Name</label>
                                <input type="text" 
                                       class="form-control @error('instructor') is-invalid @enderror" 
                                       id="instructor" 
                                       name="instructor" 
                                       value="{{ old('instructor', $course->instructor) }}">
                                @error('instructor')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="instructor_email" class="form-label">Instructor Email</label>
                                <input type="email" 
                                       class="form-control @error('instructor_email') is-invalid @enderror" 
                                       id="instructor_email" 
                                       name="instructor_email" 
                                       value="{{ old('instructor_email', $course->instructor_email) }}">
                                @error('instructor_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="schedule" class="form-label">Schedule</label>
                                <input type="text" 
                                       class="form-control @error('schedule') is-invalid @enderror" 
                                       id="schedule" 
                                       name="schedule" 
                                       value="{{ old('schedule', $course->schedule) }}">
                                @error('schedule')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="room" class="form-label">Room</label>
                                <input type="text" 
                                       class="form-control @error('room') is-invalid @enderror" 
                                       id="room" 
                                       name="room" 
                                       value="{{ old('room', $course->room) }}">
                                @error('room')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="target_grade" class="form-label">Target Grade (%)</label>
                                <input type="number" 
                                       class="form-control @error('target_grade') is-invalid @enderror" 
                                       id="target_grade" 
                                       name="target_grade" 
                                       value="{{ old('target_grade', $course->target_grade) }}" 
                                       step="0.01" 
                                       min="0" 
                                       max="100">
                                @error('target_grade')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="color_code" class="form-label">Color</label>
                                <input type="color" 
                                       class="form-control form-control-color @error('color_code') is-invalid @enderror" 
                                       id="color_code" 
                                       name="color_code" 
                                       value="{{ old('color_code', $course->color_code) }}">
                                @error('color_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3">{{ old('description', $course->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" 
                                      name="notes" 
                                      rows="4">{{ old('notes', $course->notes) }}</textarea>
                            @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="textbook" class="form-label">Textbook</label>
                            <input type="text" 
                                   class="form-control @error('textbook') is-invalid @enderror" 
                                   id="textbook" 
                                   name="textbook" 
                                   value="{{ old('textbook', $course->textbook) }}">
                            @error('textbook')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('courses.show', $course) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Course
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-chart-line"></i> Course Stats</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <span>Current Grade:</span>
                        <strong>{{ $course->current_grade ? number_format($course->current_grade, 1) . '%' : 'N/A' }}</strong>

                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Letter Grade:</span>
                        <strong>{{ $course->getLetterGrade() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Attendance:</span>
                        <strong>{{ number_format($course->attendance_percentage, 1) }}%</strong>
                    </div>
                   <div class="d-flex justify-content-between">
                    <span>Pending Assignments:</span>
                    <strong>{{ $course->getPendingAssignments() }}</strong>
                </div>
            </div>
       
            </div>
        </div>
    </div>
</div>
@endsection