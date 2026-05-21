@extends('layouts.app')

@section('title', 'Edit Grade')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1 class="fw-bold mb-1">
            <i class="fas fa-edit text-primary"></i> Edit Grade
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('grades.index') }}">Grades</a></li>
                <li class="breadcrumb-item active">Edit {{ $grade->title }}</li>
            </ol>
        </nav>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Update Grade Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('grades.update', $grade) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="course_id" class="form-label">Course <span class="text-danger">*</span></label>
                            <select class="form-select @error('course_id') is-invalid @enderror" 
                                    id="course_id" 
                                    name="course_id" 
                                    required>
                                @foreach($courses as $course)
                                <option value="{{ $course->id }}" 
                                        {{ old('course_id', $grade->course_id) == $course->id ? 'selected' : '' }}>
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
                                <label for="assessment_type" class="form-label">Assessment Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('assessment_type') is-invalid @enderror" 
                                        id="assessment_type" 
                                        name="assessment_type" 
                                        required>
                                    <option value="Quiz" {{ old('assessment_type', $grade->assessment_type) == 'Quiz' ? 'selected' : '' }}>Quiz</option>
                                    <option value="Assignment" {{ old('assessment_type', $grade->assessment_type) == 'Assignment' ? 'selected' : '' }}>Assignment</option>
                                    <option value="Midterm" {{ old('assessment_type', $grade->assessment_type) == 'Midterm' ? 'selected' : '' }}>Midterm</option>
                                    <option value="Final" {{ old('assessment_type', $grade->assessment_type) == 'Final' ? 'selected' : '' }}>Final</option>
                                    <option value="Project" {{ old('assessment_type', $grade->assessment_type) == 'Project' ? 'selected' : '' }}>Project</option>
                                    <option value="Presentation" {{ old('assessment_type', $grade->assessment_type) == 'Presentation' ? 'selected' : '' }}>Presentation</option>
                                    <option value="Lab" {{ old('assessment_type', $grade->assessment_type) == 'Lab' ? 'selected' : '' }}>Lab</option>
                                </select>
                                @error('assessment_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title', $grade->title) }}" 
                                       required>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="weightage" class="form-label">Weightage (%) <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('weightage') is-invalid @enderror" 
                                       id="weightage" 
                                       name="weightage" 
                                       value="{{ old('weightage', $grade->weightage) }}" 
                                       step="0.01" 
                                       min="0" 
                                       max="100"
                                       required>
                                @error('weightage')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="total_marks" class="form-label">Total Marks <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('total_marks') is-invalid @enderror" 
                                       id="total_marks" 
                                       name="total_marks" 
                                       value="{{ old('total_marks', $grade->total_marks) }}" 
                                       step="0.01" 
                                       min="1"
                                       required>
                                @error('total_marks')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="marks_obtained" class="form-label">Marks Obtained</label>
                                <input type="number" 
                                       class="form-control @error('marks_obtained') is-invalid @enderror" 
                                       id="marks_obtained" 
                                       name="marks_obtained" 
                                       value="{{ old('marks_obtained', $grade->marks_obtained) }}" 
                                       step="0.01" 
                                       min="0">
                                @error('marks_obtained')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" 
                                       class="form-control @error('date') is-invalid @enderror" 
                                       id="date" 
                                       name="date" 
                                       value="{{ old('date', $grade->date->format('Y-m-d')) }}" 
                                       required>
                                @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status" 
                                        required>
                                    <option value="pending" {{ old('status', $grade->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="completed" {{ old('status', $grade->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="graded" {{ old('status', $grade->status) == 'graded' ? 'selected' : '' }}>Graded</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control @error('remarks') is-invalid @enderror" 
                                      id="remarks" 
                                      name="remarks" 
                                      rows="3">{{ old('remarks', $grade->remarks) }}</textarea>
                            @error('remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($grade->percentage !== null)
                        <div class="alert alert-success">
                            <h6 class="mb-2"><i class="fas fa-check-circle"></i> Current Grade</h6>
                            <div class="d-flex justify-content-between">
                                <span>Percentage:</span>
                                <strong>{{ number_format($grade->percentage, 2) }}%</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Letter Grade:</span>
                                <strong class="badge bg-{{ $grade->course->getGradeColorClass() }}">{{ $grade->letter_grade }}</strong>
                            </div>
                        </div>
                        @endif

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('courses.show', $grade->course) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Grade
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection