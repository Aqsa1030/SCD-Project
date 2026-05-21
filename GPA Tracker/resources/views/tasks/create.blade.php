@extends('layouts.app')

@section('title', 'Create New Task')

@section('content')
<div class="create-task-page">
    <!-- Header -->
    <div class="task-header-gradient">
        <div class="container">
            <h1 class="header-title">
                <i class="fas fa-plus-circle me-3"></i>
                Create New Task
            </h1>
            <nav class="breadcrumb-nav">
                <a href="{{ route('dashboard') }}" class="breadcrumb-link">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <span class="breadcrumb-separator">›</span>
                <a href="{{ route('tasks.index') }}" class="breadcrumb-link">
                    Tasks
                </a>
                <span class="breadcrumb-separator">›</span>
                <span class="breadcrumb-current">Create</span>
            </nav>
        </div>
    </div>

    <!-- Form Content -->
    <div class="form-content-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-9 col-lg-10">
                    <form action="{{ route('tasks.store') }}" method="POST" class="task-form">
                        @csrf

                        <!-- Main Card -->
                        <div class="form-card-modern">
                            <!-- Card Header -->
                            <div class="card-header-section">
                                <div class="header-icon-badge">
                                    <i class="fas fa-tasks"></i>
                                </div>
                                <div>
                                    <h5 class="section-title">Task Details</h5>
                                    <p class="section-subtitle">Fill in the information below to create a new task</p>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body-section">
                                <!-- Task Title -->
                                <div class="form-group-modern">
                                    <label class="form-label-icon">
                                        <i class="fas fa-heading label-icon"></i>
                                        <span>Task Title <span class="required">*</span></span>
                                    </label>
                                    <input type="text" 
                                           name="title" 
                                           class="form-input-modern @error('title') is-invalid @enderror" 
                                           value="{{ old('title') }}"
                                           placeholder="e.g., Complete Assignment 1"
                                           required>
                                    @error('title')
                                    <span class="error-message">{{ $message }}</span>
                                    @enderror
                                    <small class="input-helper">
                                        <i class="fas fa-info-circle"></i>
                                        Give your task a clear, descriptive title
                                    </small>
                                </div>

                                <!-- Description -->
                                <div class="form-group-modern">
                                    <label class="form-label-icon">
                                        <i class="fas fa-align-left label-icon"></i>
                                        <span>Description</span>
                                    </label>
                                    <textarea name="description" 
                                              rows="4" 
                                              class="form-input-modern @error('description') is-invalid @enderror"
                                              placeholder="Detailed task description...">{{ old('description') }}</textarea>
                                    @error('description')
                                    <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Related Course -->
                                <div class="form-group-modern">
                                    <label class="form-label-icon">
                                        <i class="fas fa-book label-icon"></i>
                                        <span>Related Course <span class="optional">(Optional)</span></span>
                                    </label>
                                    <select name="course_id" class="form-select-modern @error('course_id') is-invalid @enderror">
                                        <option value="">None - Personal Task</option>
                                        @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->code }} - {{ $course->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('course_id')
                                    <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Date & Time Row -->
                                <div class="form-row-grid">
                                    <div class="form-group-modern">
                                        <label class="form-label-icon">
                                            <i class="fas fa-calendar-day label-icon"></i>
                                            <span>Due Date <span class="required">*</span></span>
                                        </label>
                                        <input type="date" 
                                               name="due_date" 
                                               class="form-input-modern @error('due_date') is-invalid @enderror"
                                               value="{{ old('due_date') }}"
                                               required>
                                        @error('due_date')
                                        <span class="error-message">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group-modern">
                                        <label class="form-label-icon">
                                            <i class="fas fa-clock label-icon"></i>
                                            <span>Due Time <span class="optional">(Optional)</span></span>
                                        </label>
                                        <input type="time" 
                                               name="due_time" 
                                               class="form-input-modern @error('due_time') is-invalid @enderror"
                                               value="{{ old('due_time') }}">
                                        @error('due_time')
                                        <span class="error-message">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Priority, Status & Progress Row -->
                                <div class="form-row-grid three-cols">
                                    <div class="form-group-modern">
                                        <label class="form-label-icon">
                                            <i class="fas fa-flag label-icon"></i>
                                            <span>Priority <span class="required">*</span></span>
                                        </label>
                                        <select name="priority" class="form-select-modern @error('priority') is-invalid @enderror" required>
                                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>
                                                🟢 Low
                                            </option>
                                            <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>
                                                🟡 Medium
                                            </option>
                                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>
                                                🔴 High
                                            </option>
                                        </select>
                                        @error('priority')
                                        <span class="error-message">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group-modern">
                                        <label class="form-label-icon">
                                            <i class="fas fa-check-circle label-icon"></i>
                                            <span>Status <span class="required">*</span></span>
                                        </label>
                                        <select name="status" class="form-select-modern @error('status') is-invalid @enderror" required>
                                            <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>
                                                ⏳ Pending
                                            </option>
                                            <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>
                                                🔄 In Progress
                                            </option>
                                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                                                ✅ Completed
                                            </option>
                                        </select>
                                        @error('status')
                                        <span class="error-message">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group-modern">
                                        <label class="form-label-icon">
                                            <i class="fas fa-percentage label-icon"></i>
                                            <span>Progress (%)</span>
                                        </label>
                                        <input type="number" 
                                               name="progress" 
                                               class="form-input-modern @error('progress') is-invalid @enderror"
                                               value="{{ old('progress', 0) }}"
                                               min="0"
                                               max="100">
                                        @error('progress')
                                        <span class="error-message">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Quick Tips Box -->
                                <div class="tips-box">
                                    <div class="tips-header">
                                        <i class="fas fa-lightbulb"></i>
                                        <strong>Quick Tips</strong>
                                    </div>
                                    <div class="tips-grid">
                                        <div class="tip-item">
                                            <i class="fas fa-check"></i>
                                            <span>Use clear, actionable titles for better task management</span>
                                        </div>
                                        <div class="tip-item">
                                            <i class="fas fa-check"></i>
                                            <span>Set realistic due dates to stay on track</span>
                                        </div>
                                        <div class="tip-item">
                                            <i class="fas fa-check"></i>
                                            <span>Link tasks to courses for better organization</span>
                                        </div>
                                        <div class="tip-item">
                                            <i class="fas fa-check"></i>
                                            <span>Mark high priority for urgent assignments</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Footer -->
                            <div class="card-footer-section">
                                <a href="{{ route('tasks.index') }}" class="btn-cancel-modern">
                                    <i class="fas fa-times me-2"></i>
                                    Cancel
                                </a>
                                <button type="submit" class="btn-submit-modern">
                                    <i class="fas fa-check me-2"></i>
                                    Create Task
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Main Container */
.create-task-page {
    background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
    min-height: calc(100vh - 56px);
    padding-bottom: 50px;
}

/* Header */
.task-header-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 50px 0 35px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    margin-bottom: 40px;
}

.header-title {
    color: white;
    font-size: 2.5rem;
    font-weight: 900;
    margin-bottom: 16px;
    text-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.breadcrumb-nav {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.breadcrumb-link {
    color: rgba(255,255,255,0.9);
    text-decoration: none;
    font-size: 15px;
    font-weight: 600;
    transition: all 0.3s;
}

.breadcrumb-link:hover {
    color: white;
    transform: translateX(2px);
}

.breadcrumb-separator {
    color: rgba(255,255,255,0.6);
    font-size: 18px;
}

.breadcrumb-current {
    color: white;
    font-weight: 700;
    font-size: 15px;
}

/* Form Content */
.form-content-section {
    padding: 0 20px;
}

/* Form Card */
.form-card-modern {
    background: white;
    border-radius: 28px;
    box-shadow: 0 12px 48px rgba(0,0,0,0.1);
    overflow: hidden;
}

/* Card Header */
.card-header-section {
    background: linear-gradient(to right, #f8f9fa, #ffffff);
    padding: 35px 40px;
    border-bottom: 3px solid #e9ecef;
    display: flex;
    align-items: center;
    gap: 24px;
}

.header-icon-badge {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 32px;
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
}

.section-title {
    font-size: 1.6rem;
    font-weight: 900;
    color: #2d3748;
    margin: 0;
}

.section-subtitle {
    color: #6c757d;
    font-size: 15px;
    margin: 8px 0 0 0;
}

/* Card Body */
.card-body-section {
    padding: 40px;
}

/* Form Groups */
.form-group-modern {
    margin-bottom: 32px;
}

.form-label-icon {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
    font-weight: 800;
    color: #2d3748;
    font-size: 15px;
}

.label-icon {
    color: #667eea;
    font-size: 18px;
}

.required {
    color: #ef4444;
    font-weight: 700;
    margin-left: 4px;
}

.optional {
    color: #6c757d;
    font-weight: 600;
    font-size: 13px;
}

/* Form Inputs */
.form-input-modern,
.form-select-modern {
    width: 100%;
    padding: 16px 20px;
    border: 2px solid #e9ecef;
    border-radius: 14px;
    font-size: 15px;
    font-weight: 500;
    background: #f8f9fa;
    transition: all 0.3s;
    color: #2d3748;
}

.form-input-modern:focus,
.form-select-modern:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 5px rgba(102, 126, 234, 0.1);
}

.form-input-modern::placeholder {
    color: #9ca3af;
}

textarea.form-input-modern {
    resize: vertical;
    min-height: 120px;
}

.form-select-modern {
    cursor: pointer;
}

/* Input Helper */
.input-helper {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #6c757d;
    font-size: 13px;
    margin-top: 8px;
    font-weight: 500;
}

.input-helper i {
    color: #667eea;
}

/* Error Messages */
.error-message {
    color: #ef4444;
    font-size: 13px;
    font-weight: 600;
    margin-top: 8px;
    display: block;
}

.is-invalid {
    border-color: #ef4444 !important;
    background: #fee2e2 !important;
}

/* Form Row Grid */
.form-row-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    margin-bottom: 32px;
}

.form-row-grid.three-cols {
    grid-template-columns: repeat(3, 1fr);
}

/* Tips Box */
.tips-box {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    border: 3px solid #93c5fd;
    border-radius: 20px;
    padding: 28px;
    margin-top: 40px;
}

.tips-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 20px;
    color: #1e40af;
}

.tips-header i {
    font-size: 26px;
}

.tips-header strong {
    font-size: 18px;
    font-weight: 900;
}

.tips-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 16px;
}

.tip-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    color: #1e3a8a;
    font-size: 14px;
    font-weight: 600;
}

.tip-item i {
    color: #10b981;
    font-size: 16px;
    margin-top: 3px;
}

/* Card Footer */
.card-footer-section {
    padding: 28px 40px;
    border-top: 3px solid #e9ecef;
    background: linear-gradient(to right, #ffffff, #f8f9fa);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
}

/* Buttons */
.btn-submit-modern {
    flex: 1;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 18px 40px;
    border-radius: 14px;
    font-weight: 800;
    font-size: 16px;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-submit-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(102, 126, 234, 0.4);
}

.btn-cancel-modern {
    flex: 1;
    background: #f8f9fa;
    color: #2d3748;
    padding: 18px 40px;
    border-radius: 14px;
    font-weight: 800;
    font-size: 16px;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    border: 2px solid #e9ecef;
}

.btn-cancel-modern:hover {
    background: #e9ecef;
    border-color: #667eea;
    color: #667eea;
    transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 992px) {
    .form-row-grid.three-cols {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .header-title {
        font-size: 2rem;
    }
    
    .card-header-section {
        flex-direction: column;
        text-align: center;
        padding: 28px 24px;
    }
    
    .card-body-section {
        padding: 28px 24px;
    }
    
    .form-row-grid {
        grid-template-columns: 1fr;
    }
    
    .card-footer-section {
        flex-direction: column;
        padding: 24px;
    }
    
    .tips-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 576px) {
    .form-content-section {
        padding: 0 15px;
    }
    
    .form-input-modern,
    .form-select-modern {
        padding: 14px 16px;
        font-size: 14px;
    }
}
</style>
@endpush