@extends('layouts.app')

@section('title', 'Create Semester')

@section('content')
<div class="create-semester-full">
    <div class="create-header-gradient">
        <div class="container">
            <h1 class="create-display-title">
                <i class="fas fa-plus-circle me-3"></i>
                Create New Semester
            </h1>
            <nav class="breadcrumb-navigation">
                <a href="{{ route('dashboard') }}" class="breadcrumb-link">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <span class="breadcrumb-separator">›</span>
                <a href="{{ route('semesters.index') }}" class="breadcrumb-link">
                    Semesters
                </a>
                <span class="breadcrumb-separator">›</span>
                <span class="breadcrumb-current">Create</span>
            </nav>
        </div>
    </div>
    <div class="form-content-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12">
                    <div class="form-card-centered">
                        <div class="form-header-section">
                            <div class="section-number-badge">1</div>
                            <div>
                                <h5 class="form-section-title">Semester Information</h5>
                                <p class="form-section-subtitle">Fill in the semester details below</p>
                            </div>
                        </div>

                        <div class="form-body-section">
                            <form action="{{ route('semesters.store') }}" method="POST" class="semester-form-grid">
                                @csrf

                                <div class="form-section-card">
                                    <div class="section-header-row">
                                        <i class="fas fa-tag section-icon purple-gradient"></i>
                                        <div>
                                            <h6 class="section-heading">Semester Name <span class="text-danger">*</span></h6>
                                            <p class="section-description">Give your semester a descriptive name</p>
                                        </div>
                                    </div>
                                    <div class="form-input-row">
                                        <div class="input-group-full">
                                            <div class="input-with-icon">
                                                <i class="fas fa-font"></i>
                                                <input type="text" 
                                                       name="name" 
                                                       class="form-control-enhanced @error('name') is-invalid @enderror"
                                                       placeholder="e.g., Fall Semester, Spring 2025"
                                                       value="{{ old('name') }}"
                                                       required>
                                            </div>
                                            @error('name')
                                            <div class="error-message-box">
                                                <i class="fas fa-exclamation-circle"></i>
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section-card">
                                    <div class="section-header-row">
                                        <i class="fas fa-calendar-alt section-icon blue-gradient"></i>
                                        <div>
                                            <h6 class="section-heading">Year <span class="text-danger">*</span></h6>
                                            <p class="section-description">Academic year of the semester</p>
                                        </div>
                                    </div>
                                    <div class="form-input-row">
                                        <div class="input-group-full">
                                            <div class="input-with-icon">
                                                <i class="fas fa-hashtag"></i>
                                                <input type="text" 
                                                       name="year" 
                                                       class="form-control-enhanced @error('year') is-invalid @enderror"
                                                       placeholder="2025"
                                                       value="{{ old('year', date('Y')) }}"
                                                       required>
                                            </div>
                                            @error('year')
                                            <div class="error-message-box">
                                                <i class="fas fa-exclamation-circle"></i>
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section-card">
                                    <div class="section-header-row">
                                        <i class="fas fa-calendar-days section-icon green-gradient"></i>
                                        <div>
                                            <h6 class="section-heading">Semester Dates <span class="text-danger">*</span></h6>
                                            <p class="section-description">Set the start and end dates for your semester</p>
                                        </div>
                                    </div>
                                    
                                    <div class="date-grid-table">
                                        <div class="date-grid-header">
                                            <div class="date-grid-column">
                                                <div class="date-column-icon start-icon">
                                                    <i class="fas fa-play"></i>
                                                </div>
                                                <h6>Start Date</h6>
                                            </div>
                                            <div class="date-grid-column">
                                                <div class="date-column-icon end-icon">
                                                    <i class="fas fa-flag-checkered"></i>
                                                </div>
                                                <h6>End Date</h6>
                                            </div>
                                        </div>
                                        
                                        <div class="date-grid-body">
                                            <div class="date-grid-cell">
                                                <div class="input-with-icon">
                                                    <i class="fas fa-calendar-day"></i>
                                                    <input type="date" 
                                                           name="start_date" 
                                                           class="form-control-enhanced date-input @error('start_date') is-invalid @enderror"
                                                           value="{{ old('start_date') }}"
                                                           required>
                                                </div>
                                                @error('start_date')
                                                <div class="error-message-box">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="date-grid-cell">
                                                <div class="input-with-icon">
                                                    <i class="fas fa-calendar-check"></i>
                                                    <input type="date" 
                                                           name="end_date" 
                                                           class="form-control-enhanced date-input @error('end_date') is-invalid @enderror"
                                                           value="{{ old('end_date') }}"
                                                           required>
                                                </div>
                                                @error('end_date')
                                                <div class="error-message-box">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Quick Tip Box -->
                                    <div class="quick-tip-box">
                                        <div class="tip-icon">
                                            <i class="fas fa-lightbulb"></i>
                                        </div>
                                        <div class="tip-content">
                                            <strong>Quick Tip:</strong>
                                            <p>Make sure the end date is after the start date. You can always edit these dates later.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="form-actions-section">
                                    <button type="submit" class="btn-action-submit">
                                        <i class="fas fa-check-circle me-2"></i>
                                        Create Semester
                                    </button>
                                    <a href="{{ route('semesters.index') }}" class="btn-action-cancel">
                                        <i class="fas fa-times-circle me-2"></i>
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
/* Main Container */
.create-semester-full {
    background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
    min-height: calc(100vh - 56px);
    padding-bottom: 50px;
}

/* Header */
.create-header-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 50px 0 30px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    margin-bottom: 40px;
}

.create-display-title {
    color: white;
    font-size: 2.6rem;
    font-weight: 800;
    margin-bottom: 16px;
    text-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

/* Breadcrumb */
.breadcrumb-navigation {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.breadcrumb-link {
    color: white;
    text-decoration: none;
    font-size: 15px;
    font-weight: 600;
    transition: all 0.3s;
    padding: 6px 12px;
    border-radius: 8px;
    background: rgba(255,255,255,0.1);
}

.breadcrumb-link:hover {
    background: rgba(255,255,255,0.2);
    color: white;
}

.breadcrumb-separator {
    color: rgba(255,255,255,0.7);
    font-size: 20px;
}

.breadcrumb-current {
    color: rgba(255,255,255,0.7);
    font-size: 15px;
    padding: 6px 12px;
    background: rgba(255,255,255,0.05);
    border-radius: 8px;
}

/* Form Content */
.form-content-area {
    padding: 20px 0;
}

/* Form Card */
.form-card-centered {
    background: white;
    border-radius: 24px;
    box-shadow: 0 10px 50px rgba(0,0,0,0.1);
    overflow: hidden;
    margin-bottom: 40px;
}

/* Form Header */
.form-header-section {
    background: linear-gradient(to right, #f8f9fa, #ffffff);
    padding: 30px 40px;
    border-bottom: 2px solid #e9ecef;
    display: flex;
    align-items: center;
    gap: 20px;
}

.section-number-badge {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 28px;
    font-weight: 900;
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
    flex-shrink: 0;
}

.form-section-title {
    font-size: 1.5rem;
    font-weight: 900;
    color: #2d3748;
    margin: 0 0 6px 0;
}

.form-section-subtitle {
    color: #6c757d;
    font-size: 15px;
    margin: 0;
}

/* Form Body */
.form-body-section {
    padding: 40px;
}

/* Form Sections */
.form-section-card {
    background: #f8f9fa;
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    border: 2px solid #e9ecef;
    transition: all 0.3s;
}

.form-section-card:hover {
    border-color: #667eea;
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.1);
}

.section-header-row {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 25px;
}

.section-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
    flex-shrink: 0;
}

.purple-gradient {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
}

.blue-gradient {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.green-gradient {
    background: linear-gradient(135deg, #10b981, #059669);
}

.section-heading {
    font-size: 1.2rem;
    font-weight: 800;
    color: #2d3748;
    margin: 0 0 6px 0;
}

.section-description {
    color: #6c757d;
    font-size: 14px;
    margin: 0;
}

/* Form Inputs */
.form-input-row {
    margin-top: 20px;
}

.input-group-full {
    width: 100%;
}

.input-with-icon {
    position: relative;
}

.input-with-icon i {
    position: absolute;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    font-size: 18px;
    z-index: 2;
}

.form-control-enhanced {
    width: 100%;
    padding: 18px 24px 18px 56px;
    border: 2px solid #e9ecef;
    border-radius: 14px;
    font-size: 16px;
    font-weight: 600;
    background: white;
    transition: all 0.3s;
    color: #2d3748;
}

.form-control-enhanced:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
}

.form-control-enhanced.is-invalid {
    border-color: #ef4444;
    background: linear-gradient(to right, #fee2e2, #fff5f5);
}

.form-control-enhanced::placeholder {
    color: #a0aec0;
    font-weight: 500;
}

/* Date Grid Table */
.date-grid-table {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 25px;
}

.date-grid-header {
    display: grid;
    grid-template-columns: 1fr 1fr;
    background: linear-gradient(to right, #667eea, #764ba2);
    padding: 20px;
    gap: 1px;
}

.date-grid-column {
    text-align: center;
    color: white;
    padding: 10px;
}

.date-grid-column h6 {
    font-size: 16px;
    font-weight: 800;
    margin: 12px 0 0 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.date-column-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;
    font-size: 20px;
}

.start-icon {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.end-icon {
    background: linear-gradient(135deg, #10b981, #059669);
}

.date-grid-body {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1px;
    background: #f0f0f0;
}

.date-grid-cell {
    background: white;
    padding: 25px;
    text-align: center;
}

.date-grid-cell .input-with-icon i {
    left: 15px;
    color: #667eea;
}

.date-input {
    text-align: center;
    font-weight: 700;
    padding-left: 20px;
    padding-right: 20px;
    font-size: 15px;
    cursor: pointer;
}

.date-input::-webkit-calendar-picker-indicator {
    cursor: pointer;
    opacity: 0.6;
    transition: opacity 0.3s;
}

.date-input::-webkit-calendar-picker-indicator:hover {
    opacity: 1;
}

/* Quick Tip Box */
.quick-tip-box {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    border-left: 5px solid #f59e0b;
    padding: 20px;
    border-radius: 14px;
    display: flex;
    gap: 16px;
    align-items: flex-start;
}

.tip-icon {
    width: 44px;
    height: 44px;
    background: #f59e0b;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
    flex-shrink: 0;
}

.tip-content strong {
    display: block;
    color: #92400e;
    margin-bottom: 6px;
    font-size: 15px;
    font-weight: 800;
}

.tip-content p {
    color: #92400e;
    margin: 0;
    font-size: 14px;
    font-weight: 500;
    opacity: 0.9;
}

/* Error Messages */
.error-message-box {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    border: 2px solid #ef4444;
    border-radius: 12px;
    padding: 12px 18px;
    margin-top: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
    animation: slideIn 0.3s ease;
}

.error-message-box i {
    color: #ef4444;
    font-size: 16px;
    flex-shrink: 0;
}

.error-message-box span {
    color: #b91c1c;
    font-size: 14px;
    font-weight: 600;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Form Actions */
.form-actions-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 40px;
    padding-top: 30px;
    border-top: 2px solid #e9ecef;
}

.btn-action-submit {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 18px 40px;
    border-radius: 14px;
    font-weight: 800;
    font-size: 16px;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
}

.btn-action-submit:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(102, 126, 234, 0.4);
}

.btn-action-cancel {
    background: white;
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

.btn-action-cancel:hover {
    background: #f8f9fa;
    border-color: #667eea;
    color: #667eea;
    transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 992px) {
    .form-body-section {
        padding: 30px 25px;
    }
    
    .form-header-section {
        padding: 25px 30px;
    }
    
    .date-grid-header,
    .date-grid-body {
        grid-template-columns: 1fr;
    }
    
    .date-grid-cell {
        padding: 20px;
    }
}

@media (max-width: 768px) {
    .create-display-title {
        font-size: 2rem;
    }
    
    .form-section-card {
        padding: 20px;
    }
    
    .section-header-row {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .section-icon {
        width: 48px;
        height: 48px;
        font-size: 20px;
    }
    
    .form-actions-section {
        grid-template-columns: 1fr;
    }
    
    .btn-action-submit,
    .btn-action-cancel {
        padding: 16px 30px;
        font-size: 15px;
    }
}

@media (max-width: 576px) {
    .create-header-gradient {
        padding: 40px 0 25px;
    }
    
    .form-body-section {
        padding: 20px;
    }
    
    .form-section-card {
        padding: 15px;
    }
    
    .date-grid-cell {
        padding: 15px;
    }
    
    .form-control-enhanced {
        padding: 15px 20px 15px 50px;
        font-size: 15px;
    }
}
</style>
@endpush