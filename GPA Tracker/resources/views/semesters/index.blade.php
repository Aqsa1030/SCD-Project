@extends('layouts.app')

@section('title', 'Semesters')

@section('content')
<div class="semesters-page-full">
    <div class="page-header-gradient">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-title">
                        <i class="fas fa-calendar-alt me-3"></i>
                        My Semesters
                    </h1>
                    <p class="display-subtitle">Manage your academic semesters and track your progress</p>
                </div>
                <div class="col-lg-6 text-lg-end mt-3 mt-lg-0">
                    <a href="{{ route('semesters.create') }}" class="btn-add-main">
                        <i class="fas fa-plus-circle me-2"></i>
                        Add Semester
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-area">
        <div class="container">
            @if($semesters->count() > 0)
            <div class="row g-4">
                @foreach($semesters as $semester)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="semester-card-full">
                        <div class="card-header-gradient">
                            <div class="header-content">
                                <h3 class="semester-title">{{ $semester->name }}</h3>
                                <p class="semester-year">{{ $semester->year }}</p>
                            </div>
                            @if($semester->is_active ?? false)
                            <div class="active-status">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            @endif
                        </div>

                        <div class="card-body-content">
                            <div class="dates-section mb-4">
                                <h4 class="section-title">
                                    <i class="fas fa-calendar me-2"></i>
                                    Semester Dates
                                </h4>
                                <div class="dates-grid">
                                    <div class="date-item start-date">
                                        <div class="date-icon blue-gradient">
                                            <i class="fas fa-play"></i>
                                        </div>
                                        <div class="date-info">
                                            <span class="date-label">START DATE</span>
                                            <span class="date-value">{{ $semester->start_date->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="date-item end-date">
                                        <div class="date-icon green-gradient">
                                            <i class="fas fa-flag-checkered"></i>
                                        </div>
                                        <div class="date-info">
                                            <span class="date-label">END DATE</span>
                                            <span class="date-value">{{ $semester->end_date->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="stats-section">
                                <h4 class="section-title">
                                    <i class="fas fa-chart-bar me-2"></i>
                                    Semester Overview
                                </h4>
                                <div class="stats-grid">
                                    <div class="stat-item">
                                        <div class="stat-icon purple-gradient">
                                            <i class="fas fa-book"></i>
                                        </div>
                                        <div class="stat-data">
                                            <span class="stat-number">{{ $semester->courses->count() }}</span>
                                            <span class="stat-label">COURSES</span>
                                        </div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-icon orange-gradient">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                        <div class="stat-data">
                                            @php
                                                $semesterGrades = $semester->courses->flatMap->grades;
                                                $gpa = $semesterGrades->count() > 0 ? round($semesterGrades->avg('grade_point'), 2) : 0;
                                            @endphp
                                            <span class="stat-number">{{ number_format($gpa, 2) }}</span>
                                            <span class="stat-label">GPA</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer-actions">
                            <a href="{{ route('semesters.edit', $semester) }}" class="action-button edit-btn">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </a>
                            <a href="{{ route('courses.index') }}" class="action-button view-btn">
                                <i class="fas fa-eye"></i>
                                <span>View</span>
                            </a>
                            <form action="{{ route('semesters.destroy', $semester) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this semester?')"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-button delete-btn">
                                    <i class="fas fa-trash"></i>
                                    <span>Delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-state-container">
                <div class="empty-state-content">
                    <div class="empty-icon-wrapper">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <h3 class="empty-heading">No Semesters Yet</h3>
                    <p class="empty-description">Start organizing your academic journey by creating your first semester</p>
                    <a href="{{ route('semesters.create') }}" class="btn-create-empty">
                        <i class="fas fa-plus-circle me-2"></i>
                        Create First Semester
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.semesters-page-full {
    background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
    min-height: calc(100vh - 56px);
    padding-bottom: 40px;
}
.page-header-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 60px 0 40px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    margin-bottom: 40px;
}

.display-title {
    color: white;
    font-size: 2.8rem;
    font-weight: 800;
    margin-bottom: 12px;
    text-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.display-subtitle {
    color: rgba(255,255,255,0.9);
    font-size: 1.15rem;
    margin: 0;
    font-weight: 400;
    max-width: 600px;
}

.btn-add-main {
    background: white;
    color: #667eea;
    padding: 14px 36px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 16px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s;
    box-shadow: 0 8px 24px rgba(0,0,0,0.2);
    border: none;
}

.btn-add-main:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.3);
    color: #667eea;
}

.page-content-area {
    padding: 0 20px;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
}

.semester-card-full {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    transition: all 0.4s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.semester-card-full:hover {
    transform: translateY(-8px);
    box-shadow: 0 16px 40px rgba(102, 126, 234, 0.25);
}

.card-header-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 28px 24px;
    position: relative;
    overflow: hidden;
}

.card-header-gradient::before {
    content: '';
    position: absolute;
    top: -80px;
    right: -80px;
    width: 200px;
    height: 200px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
}

.header-content {
    position: relative;
    z-index: 2;
}

.semester-title {
    color: white;
    font-size: 1.6rem;
    font-weight: 700;
    margin: 0 0 6px 0;
}

.semester-year {
    color: rgba(255,255,255,0.9);
    font-size: 1rem;
    margin: 0;
    font-weight: 500;
}

.active-status {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 36px;
    height: 36px;
    background: rgba(255,255,255,0.25);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
    backdrop-filter: blur(10px);
    z-index: 2;
}

/* Card Body */
.card-body-content {
    padding: 28px 24px;
    flex-grow: 1;
}

.section-title {
    color: #2d3748;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
}

.section-title i {
    color: #667eea;
}

/* Dates Grid */
.dates-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 28px;
}

.date-item {
    background: #f8f9fa;
    padding: 16px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: all 0.3s;
    border: 2px solid transparent;
}

.date-item:hover {
    border-color: #667eea;
    transform: translateY(-4px);
    box-shadow: 0 6px 16px rgba(102, 126, 234, 0.15);
}

.date-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
    flex-shrink: 0;
}

.blue-gradient {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.green-gradient {
    background: linear-gradient(135deg, #10b981, #059669);
}

.date-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.date-label {
    font-size: 11px;
    color: #6c757d;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.date-value {
    font-size: 15px;
    color: #2d3748;
    font-weight: 700;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.stat-item {
    background: white;
    border: 2px solid #f0f0f0;
    padding: 16px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: all 0.3s;
}

.stat-item:hover {
    border-color: #667eea;
    transform: translateY(-4px);
    box-shadow: 0 6px 16px rgba(102, 126, 234, 0.15);
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 22px;
    flex-shrink: 0;
}

.purple-gradient {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
}

.orange-gradient {
    background: linear-gradient(135deg, #f59e0b, #d97706);
}

.stat-data {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.stat-number {
    font-size: 1.6rem;
    font-weight: 800;
    color: #2d3748;
    line-height: 1;
}

.stat-label {
    font-size: 11px;
    color: #6c757d;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

/* Card Footer */
.card-footer-actions {
    padding: 20px 24px;
    background: #f8f9fa;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 12px;
    border-top: 2px solid #e9ecef;
}

.action-button {
    padding: 12px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    text-align: center;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    color: white;
}

.action-button i {
    font-size: 18px;
}

.edit-btn {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.view-btn {
    background: linear-gradient(135deg, #10b981, #059669);
}

.delete-btn {
    background: linear-gradient(135deg, #ef4444, #dc2626);
}

.action-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.15);
}

/* Empty State */
.empty-state-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 60vh;
    padding: 40px 20px;
}

.empty-state-content {
    background: white;
    border-radius: 24px;
    padding: 60px 40px;
    text-align: center;
    box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    max-width: 500px;
    width: 100%;
}

.empty-icon-wrapper {
    width: 120px;
    height: 120px;
    margin: 0 auto 32px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 12px 40px rgba(102, 126, 234, 0.3);
}

.empty-icon-wrapper i {
    font-size: 60px;
    color: white;
}

.empty-heading {
    font-size: 2rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 16px;
}

.empty-description {
    font-size: 1.1rem;
    color: #6c757d;
    margin-bottom: 32px;
    line-height: 1.6;
}

.btn-create-empty {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 16px 40px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 16px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
    border: none;
}

.btn-create-empty:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(102, 126, 234, 0.4);
    color: white;
}

/* Responsive */
@media (max-width: 1200px) {
    .container {
        max-width: 100%;
        padding: 0 20px;
    }
}

@media (max-width: 992px) {
    .display-title {
        font-size: 2.2rem;
    }
    
    .dates-grid,
    .stats-grid {
        gap: 12px;
    }
}

@media (max-width: 768px) {
    .page-header-gradient {
        padding: 40px 0 30px;
    }
    
    .display-title {
        font-size: 1.8rem;
    }
    
    .display-subtitle {
        font-size: 1rem;
    }
    
    .btn-add-main {
        padding: 12px 28px;
        font-size: 14px;
    }
    
    .semester-card-full {
        margin-bottom: 20px;
    }
    
    .card-footer-actions {
        grid-template-columns: 1fr;
    }
    
    .empty-state-content {
        padding: 40px 24px;
    }
    
    .empty-heading {
        font-size: 1.6rem;
    }
}

@media (max-width: 576px) {
    .dates-grid,
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .page-content-area {
        padding: 0 15px;
    }
}
</style>
@endpush