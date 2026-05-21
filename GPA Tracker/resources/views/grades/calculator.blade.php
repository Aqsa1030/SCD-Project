@extends('layouts.app')

@section('title', 'GPA Calculator')

@section('content')
<div class="gpa-calculator-page">
    <div class="calculator-header">
        <div class="container-fluid px-4">
            <h1 class="header-title">
                <i class="fas fa-calculator me-3"></i>
                GPA Calculator
            </h1>
            <p class="header-subtitle">Calculate your current and projected GPA</p>
        </div>
    </div>

    <div class="calculator-content">
        <div class="container-fluid px-4">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="calculator-card">
                        <div class="card-header-modern">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-list-alt me-2"></i>
                                    Course Grades
                                </h5>
                                <button type="button" class="btn btn-add-course" id="addCourseBtn">
                                    <i class="fas fa-plus-circle me-2"></i>
                                    Add Course
                                </button>
                            </div>
                        </div>
                        <div class="card-body-modern">
                            <form id="gpaCalculatorForm">
                                <div class="table-responsive">
                                    <table class="calculator-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 30%;">Course</th>
                                                <th style="width: 15%;">Credits</th>
                                                <th style="width: 18%;">Grade (%)</th>
                                                <th style="width: 15%;">Letter</th>
                                                <th style="width: 12%;">Points</th>
                                                <th style="width: 10%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="coursesTableBody">
                                            @foreach($courses as $index => $course)
                                            <tr class="course-row" data-row-id="{{ $index }}">
                                                <td>
                                                    <input type="text" 
                                                           class="form-control form-control-sm course-name-input" 
                                                           value="{{ $course->name }}" 
                                                           placeholder="Course Name"
                                                           data-row-id="{{ $index }}">
                                                    <small class="text-muted">{{ $course->code }}</small>
                                                </td>
                                                <td>
                                                    <input type="number" 
                                                           class="form-control form-control-sm credit-input text-center" 
                                                           value="{{ $course->credits }}" 
                                                           min="1" 
                                                           max="10"
                                                           data-row-id="{{ $index }}">
                                                </td>
                                                <td>
                                                    <input type="number" 
                                                           class="form-control form-control-sm grade-input text-center" 
                                                           value="{{ $course->current_grade ?? '' }}" 
                                                           min="0" 
                                                           max="100"
                                                           step="0.01"
                                                           placeholder="0-100"
                                                           data-row-id="{{ $index }}">
                                                </td>
                                                <td class="text-center">
                                                    <span class="letter-grade-display badge bg-secondary" id="letter-{{ $index }}">
                                                        {{ $course->current_grade ? $course->getLetterGrade() : 'N/A' }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="grade-points-display" id="points-{{ $index }}">
                                                        {{ $course->current_grade ? number_format($course->getGradePoint(), 1) : '0.0' }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-danger btn-remove-row" data-row-id="{{ $index }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="total-row">
                                                <td><strong>Total</strong></td>
                                                <td class="text-center"><strong id="totalCredits">0</strong></td>
                                                <td colspan="3" class="text-end"><strong>GPA: <span id="calculatedGPA">0.00</span></strong></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="calculator-actions mt-4">
                                    <button type="button" class="btn btn-calculate" id="calculateBtn">
                                        <i class="fas fa-calculator me-2"></i>
                                        Calculate GPA
                                    </button>
                                    <button type="button" class="btn btn-reset" id="resetBtn">
                                        <i class="fas fa-redo me-2"></i>
                                        Reset All
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="info-card result-card">
                        <div class="info-card-header result-header">
                            <i class="fas fa-chart-line me-2"></i>
                            Your GPA
                        </div>
                        <div class="info-card-body text-center">
                            <div class="gpa-display">
                                <h1 class="gpa-number" id="displayGPA">0.00</h1>
                                <p class="gpa-label">Grade Point Average</p>
                            </div>
                            <div class="credits-display mt-3">
                                <h3 id="displayCredits">0</h3>
                                <p>Total Credit Hours</p>
                            </div>
                        </div>
                    </div>

                    <div class="info-card mt-4">
                        <div class="info-card-header">
                            <i class="fas fa-info-circle me-2"></i>
                            Grading Scale
                        </div>
                        <div class="info-card-body">
                            <table class="grading-scale-table">
                                <tr>
                                    <td>85-100%</td>
                                    <td><strong>A+</strong></td>
                                    <td>4.0</td>
                                </tr>
                                <tr>
                                    <td>80-84%</td>
                                    <td><strong>A-</strong></td>
                                    <td>3.7</td>
                                </tr>
                                <tr>
                                    <td>75-79%</td>
                                    <td><strong>B+</strong></td>
                                    <td>3.3</td>
                                </tr>
                                <tr>
                                    <td>70-74%</td>
                                    <td><strong>B</strong></td>
                                    <td>3.0</td>
                                </tr>
                                <tr>
                                    <td>65-69%</td>
                                    <td><strong>B-</strong></td>
                                    <td>2.7</td>
                                </tr>
                                <tr>
                                    <td>60-64%</td>
                                    <td><strong>C</strong></td>
                                    <td>2.0</td>
                                </tr>
                                <tr>
                                    <td>50-59%</td>
                                    <td><strong>D</strong></td>
                                    <td>1.0</td>
                                </tr>
                                <tr>
                                    <td>&lt;50%</td>
                                    <td><strong>F</strong></td>
                                    <td>0.0</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="info-card mt-4">
                        <div class="info-card-header tips-header">
                            <i class="fas fa-lightbulb me-2"></i>
                            Tips
                        </div>
                        <div class="info-card-body">
                            <ul class="tips-list">
                                <li>
                                    <i class="fas fa-check text-success"></i>
                                    Click "Add Course" to add more courses
                                </li>
                                <li>
                                    <i class="fas fa-check text-success"></i>
                                    Enter hypothetical grades to see potential GPA
                                </li>
                                <li>
                                    <i class="fas fa-check text-success"></i>
                                    Higher credit courses impact GPA more
                                </li>
                                <li>
                                    <i class="fas fa-check text-success"></i>
                                    GPA auto-updates when you enter grades
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.gpa-calculator-page {
    background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
    min-height: calc(100vh - 56px);
    padding-bottom: 40px;
}
.calculator-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 50px 0;
    box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    margin-bottom: 40px;
}

.header-title {
    color: white;
    font-size: 2.5rem;
    font-weight: 900;
    margin-bottom: 10px;
    text-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.header-subtitle {
    color: rgba(255,255,255,0.95);
    font-size: 1.1rem;
    margin: 0;
}

.calculator-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
}

.card-header-modern {
    background: linear-gradient(to right, #f8f9fa, #ffffff);
    padding: 25px 30px;
    border-bottom: 3px solid #e9ecef;
}

.card-header-modern h5 {
    font-size: 1.4rem;
    font-weight: 800;
    color: #2d3748;
}

.btn-add-course {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-add-course:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
}

.card-body-modern {
    padding: 30px;
}

.calculator-table {
    width: 100%;
    margin-bottom: 0;
}

.calculator-table thead {
    background: linear-gradient(to right, #f8f9fa, #ffffff);
}

.calculator-table th {
    padding: 16px 12px;
    font-weight: 800;
    color: #2d3748;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 3px solid #e9ecef;
}

.calculator-table td {
    padding: 12px;
    vertical-align: middle;
    border-bottom: 1px solid #f0f0f0;
}

.course-name-input {
    font-weight: 600;
    border: 1px solid #e9ecef;
}

.credit-input,
.grade-input {
    font-weight: 600;
    border: 1px solid #e9ecef;
}

.letter-grade-display {
    font-size: 13px;
    font-weight: 800;
    padding: 6px 12px;
}

.grade-points-display {
    font-size: 1rem;
    font-weight: 800;
    color: #2d3748;
}

.btn-remove-row {
    padding: 6px 10px;
    border-radius: 6px;
}

.total-row {
    background: linear-gradient(135deg, #e0f2fe, #bfdbfe);
    font-size: 1.1rem;
}

.total-row td {
    padding: 20px 12px;
    border-bottom: none;
}

.calculator-actions {
    display: flex;
    gap: 16px;
}

.btn-calculate {
    flex: 1;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 16px 32px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 16px;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
}

.btn-calculate:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
}

.btn-reset {
    background: #f8f9fa;
    color: #2d3748;
    padding: 16px 32px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 16px;
    border: 2px solid #e9ecef;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-reset:hover {
    background: #e9ecef;
    border-color: #667eea;
    color: #667eea;
}

.info-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.info-card-header {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    padding: 20px;
    font-weight: 800;
    font-size: 1.1rem;
}

.result-header {
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.tips-header {
    background: linear-gradient(135deg, #10b981, #059669);
}

.info-card-body {
    padding: 25px;
}

.gpa-display {
    padding: 20px 0;
}

.gpa-number {
    font-size: 4rem;
    font-weight: 900;
    color: #667eea;
    margin: 0;
    line-height: 1;
}

.gpa-label {
    color: #6c757d;
    font-size: 14px;
    margin: 10px 0 0 0;
    font-weight: 600;
}

.credits-display h3 {
    font-size: 2.5rem;
    font-weight: 800;
    color: #2d3748;
    margin: 0;
}

.credits-display p {
    color: #6c757d;
    font-size: 14px;
    margin: 8px 0 0 0;
}

.grading-scale-table {
    width: 100%;
}

.grading-scale-table tr {
    border-bottom: 1px solid #f0f0f0;
}

.grading-scale-table tr:last-child {
    border-bottom: none;
}

.grading-scale-table td {
    padding: 12px 8px;
    font-size: 14px;
}

.grading-scale-table td:nth-child(2) {
    text-align: center;
    color: #667eea;
    font-weight: 800;
}

.grading-scale-table td:nth-child(3) {
    text-align: right;
    font-weight: 700;
}
.tips-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.tips-list li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 16px;
    font-size: 14px;
    color: #2d3748;
}

.tips-list li:last-child {
    margin-bottom: 0;
}

.tips-list i {
    margin-top: 3px;
    font-size: 16px;
}

@media (max-width: 768px) {
    .calculator-actions {
        flex-direction: column;
    }
    
    .calculator-table {
        font-size: 12px;
    }
    
    .calculator-table th,
    .calculator-table td {
        padding: 8px 6px;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let rowCounter = {{ $courses->count() }};
    
    function getLetterGrade(percentage) {
        percentage = parseFloat(percentage);
        if (isNaN(percentage) || percentage === 0) return 'N/A';
        if (percentage >= 90) return 'A+';
        if (percentage >= 85) return 'A';
        if (percentage >= 80) return 'A-';
        if (percentage >= 75) return 'B+';
        if (percentage >= 70) return 'B';
        if (percentage >= 65) return 'B-';
        if (percentage >= 60) return 'C+';
        if (percentage >= 55) return 'C';
        if (percentage >= 50) return 'C-';
        if (percentage >= 45) return 'D';
        return 'F';
    }
    
    function getGradePoints(percentage) {
        percentage = parseFloat(percentage);
        if (isNaN(percentage) || percentage === 0) return 0;
        if (percentage >= 90) return 4.0;
        if (percentage >= 85) return 4.0;
        if (percentage >= 80) return 3.7;
        if (percentage >= 75) return 3.3;
        if (percentage >= 70) return 3.0;
        if (percentage >= 65) return 2.7;
        if (percentage >= 60) return 2.3;
        if (percentage >= 55) return 2.0;
        if (percentage >= 50) return 1.7;
        if (percentage >= 45) return 1.0;
        return 0.0;
    }
    
    function calculateGPA() {
        let totalCredits = 0;
        let totalGradePoints = 0;
        
        document.querySelectorAll('.course-row').forEach(function(row) {
            const rowId = row.getAttribute('data-row-id');
            const gradeInput = row.querySelector('.grade-input');
            const creditInput = row.querySelector('.credit-input');
            
            const grade = parseFloat(gradeInput.value) || 0;
            const credits = parseFloat(creditInput.value) || 0;
            
            if (grade > 0 && credits > 0) {
                const gradePoints = getGradePoints(grade);
                const letterGrade = getLetterGrade(grade);
                
                const letterElement = document.getElementById('letter-' + rowId);
                const pointsElement = document.getElementById('points-' + rowId);
                
                if (letterElement) letterElement.textContent = letterGrade;
                if (pointsElement) pointsElement.textContent = gradePoints.toFixed(1);
                
                totalCredits += credits;
                totalGradePoints += (gradePoints * credits);
            }
        });
        
        const gpa = totalCredits > 0 ? (totalGradePoints / totalCredits) : 0;
        
        document.getElementById('totalCredits').textContent = totalCredits;
        document.getElementById('calculatedGPA').textContent = gpa.toFixed(2);
        document.getElementById('displayGPA').textContent = gpa.toFixed(2);
        document.getElementById('displayCredits').textContent = totalCredits;
    }
    
    document.getElementById('addCourseBtn').addEventListener('click', function() {
        rowCounter++;
        const tbody = document.getElementById('coursesTableBody');
        
        const newRow = document.createElement('tr');
        newRow.className = 'course-row';
        newRow.setAttribute('data-row-id', rowCounter);
        newRow.innerHTML = `
            <td>
                <input type="text" 
                       class="form-control form-control-sm course-name-input" 
                       value="New Course ${rowCounter}" 
                       placeholder="Course Name"
                       data-row-id="${rowCounter}">
            </td>
            <td>
                <input type="number" 
                       class="form-control form-control-sm credit-input text-center" 
                       value="3" 
                       min="1" 
                       max="10"
                       data-row-id="${rowCounter}">
            </td>
            <td>
                <input type="number" 
                       class="form-control form-control-sm grade-input text-center" 
                       value="" 
                       min="0" 
                       max="100"
                       step="0.01"
                       placeholder="0-100"
                       data-row-id="${rowCounter}">
            </td>
            <td class="text-center">
                <span class="letter-grade-display badge bg-secondary" id="letter-${rowCounter}">N/A</span>
            </td>
            <td class="text-center">
                <span class="grade-points-display" id="points-${rowCounter}">0.0</span>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger btn-remove-row" data-row-id="${rowCounter}">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        
        tbody.appendChild(newRow);
        
        newRow.querySelectorAll('.grade-input, .credit-input').forEach(function(input) {
            input.addEventListener('input', calculateGPA);
        });
        
        newRow.querySelector('.btn-remove-row').addEventListener('click', function() {
            newRow.remove();
            calculateGPA();
        });
        
        calculateGPA();
    });
    
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-remove-row') || e.target.closest('.btn-remove-row')) {
            const btn = e.target.classList.contains('btn-remove-row') ? e.target : e.target.closest('.btn-remove-row');
            const row = btn.closest('.course-row');
            if (row) {
                row.remove();
                calculateGPA();
            }
        }
    });
    
    document.getElementById('calculateBtn').addEventListener('click', function(e) {
        e.preventDefault();
        calculateGPA();
    });
    
    document.getElementById('resetBtn').addEventListener('click', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to reset all grades?')) {
            document.querySelectorAll('.grade-input').forEach(function(input) {
                input.value = '';
            });
            calculateGPA();
        }
    });
    document.querySelectorAll('.grade-input, .credit-input').forEach(function(input) {
        input.addEventListener('input', calculateGPA);
    });
    
    calculateGPA();
});
</script>
@endpush