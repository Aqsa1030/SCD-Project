@extends('layouts.app')

@section('title', 'Add Grade')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-white">
                            <h2 class="fw-bold mb-2">
                                <i class="fas fa-plus-circle me-2"></i>Add New Grade
                            </h2>
                            <p class="mb-0 opacity-90">Record and track your assessment performance</p>
                        </div>
                        <a href="{{ route('grades.index') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>Back to Grades
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('grades.store') }}" method="POST">
                @csrf
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="fas fa-book text-primary me-2"></i>Course Information
                        </h5>
                        
                        <div class="mb-0">
                            <label for="course_id" class="form-label fw-semibold">
                                Select Course <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-select-lg @error('course_id') is-invalid @enderror" 
                                    id="course_id" 
                                    name="course_id" 
                                    required
                                    style="border-radius: 10px;">
                                <option value="">Choose a course...</option>
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
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="fas fa-clipboard-list text-success me-2"></i>Assessment Details
                        </h5>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="assessment_type" class="form-label fw-semibold">
                                    Assessment Type <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-lg @error('assessment_type') is-invalid @enderror" 
                                        id="assessment_type" 
                                        name="assessment_type" 
                                        required
                                        style="border-radius: 10px;">
                                    <option value="">Select type...</option>
                                    <option value="Quiz" {{ old('assessment_type') == 'Quiz' ? 'selected' : '' }}>📝 Quiz</option>
                                    <option value="Assignment" {{ old('assessment_type') == 'Assignment' ? 'selected' : '' }}>📄 Assignment</option>
                                    <option value="Midterm" {{ old('assessment_type') == 'Midterm' ? 'selected' : '' }}>📚 Midterm</option>
                                    <option value="Final" {{ old('assessment_type') == 'Final' ? 'selected' : '' }}>🎓 Final</option>
                                    <option value="Project" {{ old('assessment_type') == 'Project' ? 'selected' : '' }}>💼 Project</option>
                                    <option value="Presentation" {{ old('assessment_type') == 'Presentation' ? 'selected' : '' }}>🎤 Presentation</option>
                                    <option value="Lab" {{ old('assessment_type') == 'Lab' ? 'selected' : '' }}>🔬 Lab</option>
                                </select>
                                @error('assessment_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="title" class="form-label fw-semibold">
                                    Title <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title') }}" 
                                       placeholder="e.g., Quiz 1, Midterm Exam"
                                       required
                                       style="border-radius: 10px;">
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="date" class="form-label fw-semibold">
                                    Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control form-control-lg @error('date') is-invalid @enderror" 
                                       id="date" 
                                       name="date" 
                                       value="{{ old('date', date('Y-m-d')) }}" 
                                       required
                                       style="border-radius: 10px;">
                                @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="status" class="form-label fw-semibold">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-lg @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status" 
                                        required
                                        style="border-radius: 10px;">
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>✅ Completed</option>
                                    <option value="graded" {{ old('status', 'graded') == 'graded' ? 'selected' : '' }}>🎯 Graded</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="fas fa-calculator text-warning me-2"></i>Marks & Weightage
                        </h5>

                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="weightage" class="form-label fw-semibold">
                                    Weightage (%) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    <input type="number" 
                                           class="form-control @error('weightage') is-invalid @enderror" 
                                           id="weightage" 
                                           name="weightage" 
                                           value="{{ old('weightage') }}" 
                                           step="0.01" 
                                           min="0" 
                                           max="100"
                                           placeholder="20"
                                           required
                                           style="border-radius: 10px 0 0 10px;">
                                    <span class="input-group-text" style="border-radius: 0 10px 10px 0; background: #f8f9fa;">
                                        <i class="fas fa-percent"></i>
                                    </span>
                                    @error('weightage')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Weight in final grade</small>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="total_marks" class="form-label fw-semibold">
                                    Total Marks <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control form-control-lg @error('total_marks') is-invalid @enderror" 
                                       id="total_marks" 
                                       name="total_marks" 
                                       value="{{ old('total_marks') }}" 
                                       step="0.01" 
                                       min="1"
                                       placeholder="100"
                                       required
                                       style="border-radius: 10px;">
                                @error('total_marks')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="marks_obtained" class="form-label fw-semibold">
                                    Marks Obtained
                                </label>
                                <input type="number" 
                                       class="form-control form-control-lg @error('marks_obtained') is-invalid @enderror" 
                                       id="marks_obtained" 
                                       name="marks_obtained" 
                                       value="{{ old('marks_obtained') }}" 
                                       step="0.01" 
                                       min="0"
                                       placeholder="85"
                                       style="border-radius: 10px;">
                                @error('marks_obtained')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Leave blank if not graded</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">
                            <i class="fas fa-comment-alt text-info me-2"></i>Additional Notes
                        </h5>
                        
                        <div class="mb-0">
                            <label for="remarks" class="form-label fw-semibold">Remarks (Optional)</label>
                            <textarea class="form-control @error('remarks') is-invalid @enderror" 
                                      id="remarks" 
                                      name="remarks" 
                                      rows="4" 
                                      placeholder="Add any additional notes or comments about this assessment..."
                                      style="border-radius: 10px;">{{ old('remarks') }}</textarea>
                            @error('remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 mb-4">
                    <a href="{{ route('grades.index') }}" class="btn btn-lg btn-light flex-fill" style="border-radius: 10px;">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-lg btn-primary flex-fill" style="border-radius: 10px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                        <i class="fas fa-save me-2"></i>Save Grade
                    </button>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <div class="sticky-top" style="top: 20px;">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <div class="card-body p-4 text-white">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-calculator me-2"></i>Grade Preview
                        </h5>
                        <div id="gradePreview">
                            <div class="text-center py-4">
                                <i class="fas fa-chart-line fa-3x mb-3 opacity-75"></i>
                                <p class="mb-0">Enter marks to see calculation</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-lightbulb text-warning me-2"></i>Quick Tips
                        </h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <small>Ensure weightage adds up to 100% for the course</small>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <small>You can add marks later if not available</small>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <small>Use clear titles like "Quiz 1", "Midterm"</small>
                            </li>
                            <li class="mb-0">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <small>Double-check dates before saving</small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const marksObtained = document.getElementById('marks_obtained');
    const totalMarks = document.getElementById('total_marks');
    const gradePreview = document.getElementById('gradePreview');

    function calculateGrade() {
        const obtained = parseFloat(marksObtained.value) || 0;
        const total = parseFloat(totalMarks.value) || 0;

        if (total > 0 && obtained >= 0) {
            const percentage = (obtained / total) * 100;
            let letterGrade = '';
            let gradeIcon = '';

            if (percentage >= 85) { 
                letterGrade = 'A+'; 
                gradeIcon = '🌟';
            } else if (percentage >= 80) { 
                letterGrade = 'A-'; 
                gradeIcon = '⭐';
            } else if (percentage >= 75) { 
                letterGrade = 'B+'; 
                gradeIcon = '💫';
            } else if (percentage >= 70) { 
                letterGrade = 'B'; 
                gradeIcon = '✨';
            } else if (percentage >= 65) { 
                letterGrade = 'B-'; 
                gradeIcon = '💪';
            } else if (percentage >= 60) { 
                letterGrade = 'C'; 
                gradeIcon = '👍';
            } else if (percentage >= 50) { 
                letterGrade = 'D'; 
                gradeIcon = '📈';
            } else { 
                letterGrade = 'F'; 
                gradeIcon = '📊';
            }

            gradePreview.innerHTML = `
                <div class="text-center">
                    <div class="display-1 mb-3">${gradeIcon}</div>
                    <h2 class="fw-bold mb-2">${letterGrade}</h2>
                    <h4 class="mb-3">${percentage.toFixed(2)}%</h4>
                    <div class="bg-white bg-opacity-25 rounded-3 p-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-semibold">Obtained:</span>
                            <span>${obtained}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold">Total:</span>
                            <span>${total}</span>
                        </div>
                    </div>
                </div>
            `;
        } else {
            gradePreview.innerHTML = `
                <div class="text-center py-4">
                    <i class="fas fa-chart-line fa-3x mb-3 opacity-75"></i>
                    <p class="mb-0">Enter marks to see calculation</p>
                </div>
            `;
        }
    }

    marksObtained.addEventListener('input', calculateGrade);
    totalMarks.addEventListener('input', calculateGrade);
    
    calculateGrade();
});
</script>

<style>
    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
    }
    
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }
    
    .btn {
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
</style>
@endsection