@extends('layouts.app')

@section('title', 'Add Course')

@section('content')
<div class="create-course-full">
    <div class="create-header-gradient">
        <div class="container">
            <h1 class="create-display-title">
                <i class="fas fa-plus-circle me-3"></i>
                Add New Course
            </h1>
            <nav class="breadcrumb-navigation">
                <a href="{{ route('dashboard') }}" class="breadcrumb-link">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <span class="breadcrumb-separator">›</span>
                <a href="{{ route('courses.index') }}" class="breadcrumb-link">
                    Courses
                </a>
                <span class="breadcrumb-separator">›</span>
                <span class="breadcrumb-current">Add</span>
            </nav>
        </div>
    </div>

    <div class="form-content-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="form-card-centered">
                        <div class="form-header-section">
                            <div class="form-icon-circle">
                                <i class="fas fa-book"></i>
                            </div>
                            <div>
                                <h5 class="form-section-title">Course Information</h5>
                                <p class="form-section-subtitle">Fill in all required details for the new course</p>
                            </div>
                        </div>

                        <div class="form-body-section">
                            <form action="{{ route('courses.store') }}" method="POST" class="course-form-grid">
                                @csrf

                                <div class="form-field-row">
                                    <div class="field-label-group">
                                        <i class="fas fa-calendar-alt field-icon"></i>
                                        <label>Semester <span class="required-star">*</span></label>
                                    </div>
                                    <div class="field-input-group">
                                        <select name="semester_id" class="form-select-enhanced" required>
                                            <option value="">Select Semester...</option>
                                            @foreach($semesters as $semester)
                                            <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                                                {{ $semester->name }} ({{ $semester->year }})
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('semester_id')<span class="field-error">{{ $message }}</span>@enderror
                                    </div>
                                </div>

                                <div class="form-grid-row">
                                    <div class="form-field-column">
                                        <div class="field-label-group">
                                            <i class="fas fa-hashtag field-icon"></i>
                                            <label>Course Code <span class="required-star">*</span></label>
                                        </div>
                                        <div class="field-input-group">
                                            <input type="text" 
                                                   name="course_code" 
                                                   value="{{ old('course_code') }}" 
                                                   placeholder="e.g., CS101"
                                                   required>
                                            @error('course_code')<span class="field-error">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="form-field-column">
                                        <div class="field-label-group">
                                            <i class="fas fa-balance-scale field-icon"></i>
                                            <label>Credit Hours <span class="required-star">*</span></label>
                                        </div>
                                        <div class="field-input-group">
                                            <input type="number" 
                                                   name="credit_hours" 
                                                   value="{{ old('credit_hours', 3) }}" 
                                                   min="1" 
                                                   max="6"
                                                   required>
                                            @error('credit_hours')<span class="field-error">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-field-row">
                                    <div class="field-label-group">
                                        <i class="fas fa-book-open field-icon"></i>
                                        <label>Course Name <span class="required-star">*</span></label>
                                    </div>
                                    <div class="field-input-group">
                                        <input type="text" 
                                               name="course_name" 
                                               value="{{ old('course_name') }}" 
                                               placeholder="e.g., Introduction to Programming"
                                               required>
                                        @error('course_name')<span class="field-error">{{ $message }}</span>@enderror
                                    </div>
                                </div>

                                <div class="form-grid-row">
                                    <div class="form-field-column">
                                        <div class="field-label-group">
                                            <i class="fas fa-user-tie field-icon"></i>
                                            <label>Instructor Name</label>
                                        </div>
                                        <div class="field-input-group">
                                            <input type="text" 
                                                   name="instructor" 
                                                   value="{{ old('instructor') }}" 
                                                   placeholder="e.g., Dr. John Smith">
                                            @error('instructor')<span class="field-error">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="form-field-column">
                                        <div class="field-label-group">
                                            <i class="fas fa-envelope field-icon"></i>
                                            <label>Instructor Email</label>
                                        </div>
                                        <div class="field-input-group">
                                            <input type="email" 
                                                   name="instructor_email" 
                                                   value="{{ old('instructor_email') }}" 
                                                   placeholder="instructor@university.edu">
                                            @error('instructor_email')<span class="field-error">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-grid-row">
                                    <div class="form-field-column">
                                        <div class="field-label-group">
                                            <i class="fas fa-clock field-icon"></i>
                                            <label>Schedule</label>
                                        </div>
                                        <div class="field-input-group">
                                            <input type="text" 
                                                   name="schedule" 
                                                   value="{{ old('schedule') }}" 
                                                   placeholder="e.g., Mon/Wed 10:00-11:30">
                                            @error('schedule')<span class="field-error">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="form-field-column">
                                        <div class="field-label-group">
                                            <i class="fas fa-door-closed field-icon"></i>
                                            <label>Room</label>
                                        </div>
                                        <div class="field-input-group">
                                            <input type="text" 
                                                   name="room" 
                                                   value="{{ old('room') }}" 
                                                   placeholder="e.g., Room 201">
                                            @error('room')<span class="field-error">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-grid-row">
                                    <div class="form-field-column">
                                        <div class="field-label-group">
                                            <i class="fas fa-bullseye field-icon"></i>
                                            <label>Target Grade (%)</label>
                                        </div>
                                        <div class="field-input-group">
                                            <input type="number" 
                                                   name="target_grade" 
                                                   value="{{ old('target_grade') }}" 
                                                   step="0.01" 
                                                   min="0" 
                                                   max="100"
                                                   placeholder="e.g., 85">
                                            @error('target_grade')<span class="field-error">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="form-field-column">
                                        <div class="field-label-group">
                                            <i class="fas fa-palette field-icon"></i>
                                            <label>Color</label>
                                        </div>
                                        <div class="field-input-group color-input-group">
                                            <input type="color" 
                                                   name="color_code" 
                                                   value="{{ old('color_code', '#4361ee') }}"
                                                   class="color-picker">
                                            <span class="color-preview" style="background: {{ old('color_code', '#4361ee') }}"></span>
                                            @error('color_code')<span class="field-error">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-field-row">
                                    <div class="field-label-group">
                                        <i class="fas fa-align-left field-icon"></i>
                                        <label>Description</label>
                                    </div>
                                    <div class="field-input-group">
                                        <textarea name="description" rows="2" placeholder="Brief course description...">{{ old('description') }}</textarea>
                                        @error('description')<span class="field-error">{{ $message }}</span>@enderror
                                    </div>
                                </div>

                                <!-- Row 8: Textbook -->
                                <div class="form-field-row">
                                    <div class="field-label-group">
                                        <i class="fas fa-book field-icon"></i>
                                        <label>Textbook</label>
                                    </div>
                                    <div class="field-input-group">
                                        <input type="text" 
                                               name="textbook" 
                                               value="{{ old('textbook') }}" 
                                               placeholder="Required textbook name">
                                        @error('textbook')<span class="field-error">{{ $message }}</span>@enderror
                                    </div>
                                </div>

                                <div class="quick-tips-box">
                                    <div class="tip-header">
                                        <i class="fas fa-lightbulb"></i>
                                        <strong>Quick Tips</strong>
                                    </div>
                                    <div class="tips-grid">
                                        <div class="tip-item">
                                            <i class="fas fa-check"></i>
                                            <span>Use clear course codes (e.g., CS101, MATH201)</span>
                                        </div>
                                        <div class="tip-item">
                                            <i class="fas fa-check"></i>
                                            <span>Set realistic target grades</span>
                                        </div>
                                        <div class="tip-item">
                                            <i class="fas fa-check"></i>
                                            <span>Choose distinct colors for easy identification</span>
                                        </div>
                                        <div class="tip-item">
                                            <i class="fas fa-check"></i>
                                            <span>Include complete schedule information</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions-row">
                                    <button type="submit" class="btn-submit-action">
                                        <i class="fas fa-plus-circle me-2"></i>
                                        Add Course
                                    </button>
                                    <a href="{{ route('courses.index') }}" class="btn-cancel-action">
                                        <i class="fas fa-times me-2"></i>
                                        Cancel
                                    </a>
                                </div>
                            </form>
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
.create-course-full {
    background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
    min-height: calc(100vh - 56px);
    padding-bottom: 40px;
}
.create-header-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 40px 0 30px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    margin-bottom: 40px;
}
.create-display-title {
    color: white;
    font-size: 2.2rem;
    font-weight: 800;
    margin-bottom: 16px;
}
.breadcrumb-navigation {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.breadcrumb-link {
    color: rgba(255,255,255,0.9);
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
}
.breadcrumb-separator { color: rgba(255,255,255,0.6); }
.breadcrumb-current { color: white; font-weight: 700; }
.form-content-area { padding: 0 20px; }
.form-card-centered {
    background: white;
    border-radius: 24px;
    box-shadow: 0 10px 50px rgba(0,0,0,0.1);
    overflow: hidden;
}
.form-header-section {
    background: linear-gradient(to right, #f8f9fa, #ffffff);
    padding: 30px;
    border-bottom: 2px solid #e9ecef;
    display: flex;
    align-items: center;
    gap: 20px;
}
.form-icon-circle {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 26px;
}
.form-section-title {
    font-size: 1.4rem;
    font-weight: 800;
    color: #2d3748;
    margin: 0;
}
.form-section-subtitle {
    color: #6c757d;
    font-size: 14px;
    margin: 8px 0 0 0;
}
.form-body-section { padding: 30px; }
.course-form-grid { display: flex; flex-direction: column; gap: 25px; }
.form-field-row, .form-grid-row { display: flex; gap: 20px; }
.form-grid-row { display: grid; grid-template-columns: 1fr 1fr; }
.form-field-column { display: flex; flex-direction: column; gap: 8px; }
.field-label-group {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
}
.field-icon {
    color: #667eea;
    font-size: 18px;
}
.field-label-group label {
    font-weight: 700;
    color: #2d3748;
    font-size: 15px;
}
.required-star { color: #ef4444; margin-left: 2px; }
.field-input-group input,
.field-input-group select,
.field-input-group textarea {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 500;
    background: #f8f9fa;
    transition: all 0.3s;
}
.field-input-group input:focus,
.field-input-group select:focus,
.field-input-group textarea:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
}
.form-select-enhanced { cursor: pointer; }
.color-input-group {
    display: flex;
    align-items: center;
    gap: 15px;
}
.color-picker {
    width: 50px;
    height: 50px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    padding: 5px;
}
.color-preview {
    width: 30px;
    height: 30px;
    border-radius: 8px;
    border: 2px solid #e9ecef;
}
.field-error {
    color: #ef4444;
    font-size: 13px;
    font-weight: 600;
    margin-top: 6px;
    display: block;
}
.quick-tips-box {
    background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
    border: 2px solid #bae6fd;
    border-radius: 16px;
    padding: 24px;
    margin: 20px 0;
}
.tip-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
    color: #0369a1;
}
.tip-header i { font-size: 22px; }
.tip-header strong { font-size: 17px; font-weight: 800; }
.tips-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 14px;
}
.tip-item {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #0c4a6e;
    font-size: 14px;
}
.tip-item i {
    color: #059669;
    font-size: 16px;
}
.form-actions-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 30px;
    padding-top: 30px;
    border-top: 2px solid #e9ecef;
}
.btn-submit-action {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 16px 32px;
    border-radius: 14px;
    font-weight: 700;
    font-size: 16px;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}
.btn-submit-action:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
}
.btn-cancel-action {
    background: #f8f9fa;
    color: #2d3748;
    padding: 16px 32px;
    border-radius: 14px;
    font-weight: 700;
    font-size: 16px;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    border: 2px solid #e9ecef;
}
.btn-cancel-action:hover {
    background: #e9ecef;
    border-color: #667eea;
    color: #667eea;
}
@media (max-width: 768px) {
    .form-grid-row { grid-template-columns: 1fr; }
    .form-header-section { padding: 24px; flex-direction: column; text-align: center; }
    .form-body-section { padding: 24px; }
    .form-actions-row { grid-template-columns: 1fr; }
    .tips-grid { grid-template-columns: 1fr; }
}
@media (max-width: 576px) {
    .create-display-title { font-size: 1.8rem; }
    .form-content-area { padding: 0 15px; }
    .field-input-group input,
    .field-input-group select,
    .field-input-group textarea {
        padding: 12px 16px;
        font-size: 14px;
    }
}
</style>
@endpush