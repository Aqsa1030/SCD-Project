@extends('layouts.app')

@section('title', 'Statistics')

@section('content')
<div class="container-fluid">
 
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">
                <i class="fas fa-chart-bar text-primary"></i> Academic Statistics
            </h1>
            <p class="text-muted mb-0">Detailed analysis of your academic performance</p>
        </div>
        <div>
            <a href="{{ route('reports.transcript') }}" class="btn btn-primary">
                <i class="fas fa-file-pdf"></i> Generate Report
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card text-center">
                <div class="card-body">
                    <i class="fas fa-tasks fa-3x text-primary mb-3"></i>
                    <h2 class="mb-1">{{ $totalTasks }}</h2>
                    <h6 class="text-muted">Total Tasks</h6>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card text-center" style="border-left-color: #06d6a0;">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <h2 class="mb-1">{{ $completedTasks }}</h2>
                    <h6 class="text-muted">Completed Tasks</h6>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card text-center" style="border-left-color: #ffd60a;">
                <div class="card-body">
                    <i class="fas fa-percentage fa-3x text-warning mb-3"></i>
                    <h2 class="mb-1">{{ number_format($taskCompletionRate, 1) }}%</h2>
                    <h6 class="text-muted">Completion Rate</h6>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card text-center" style="border-left-color: #ef476f;">
                <div class="card-body">
                    <i class="fas fa-clock fa-3x text-danger mb-3"></i>
                    <h2 class="mb-1">{{ $totalTasks - $completedTasks }}</h2>
                    <h6 class="text-muted">Pending Tasks</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-line"></i> GPA Trend Over Semesters</h5>
                </div>
                <div class="card-body">
                    <canvas id="gpaChart" height="80"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Grade Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="gradeChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Grade Breakdown by Letter</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        @foreach($gradeDistribution as $grade => $count)
                        <div class="col-md-3 mb-3">
                            <div class="p-3 border rounded">
                                <h1 class="grade-{{ str_replace('+', '\+', $grade) }} mb-2">{{ $count }}</h1>
                                <h5 class="text-muted mb-0">Grade {{ $grade }}</h5>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-thumbs-up"></i> Strengths</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        @if($taskCompletionRate >= 80)
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Excellent task completion rate ({{ number_format($taskCompletionRate, 1) }}%)
                        </li>
                        @endif
                        @if($gradeDistribution['A+'] + $gradeDistribution['A-'] > 0)
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            {{ $gradeDistribution['A+'] + $gradeDistribution['A-'] }} A-grade courses
                        </li>
                        @endif
                        @if(auth()->user()->calculateOverallGPA() >= 3.5)
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            Outstanding overall GPA ({{ number_format(auth()->user()->calculateOverallGPA(), 2) }})
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Areas for Improvement</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        @if($taskCompletionRate < 70)
                        <li class="mb-2">
                            <i class="fas fa-arrow-right text-warning me-2"></i>
                            Consider improving task completion rate
                        </li>
                        @endif
                        @if($gradeDistribution['D'] + $gradeDistribution['F'] > 0)
                        <li class="mb-2">
                            <i class="fas fa-arrow-right text-warning me-2"></i>
                            {{ $gradeDistribution['D'] + $gradeDistribution['F'] }} course(s) need attention
                        </li>
                        @endif
                        @if(auth()->user()->calculateOverallGPA() < 3.0)
                        <li class="mb-2">
                            <i class="fas fa-arrow-right text-warning me-2"></i>
                            Focus on improving overall GPA
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const gpaCtx = document.getElementById('gpaChart');
if(gpaCtx) {
    new Chart(gpaCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($gpaData->pluck('name')) !!},
            datasets: [{
                label: 'GPA',
                data: {!! json_encode($gpaData->pluck('gpa')) !!},
                borderColor: '#4361ee',
                backgroundColor: 'rgba(67, 97, 238, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 6,
                pointHoverRadius: 8,
                pointBackgroundColor: '#4361ee',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 4.0,
                    ticks: {
                        stepSize: 0.5
                    }
                }
            }
        }
    });
}

const gradeCtx = document.getElementById('gradeChart');
if(gradeCtx) {
    new Chart(gradeCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($gradeDistribution)) !!},
            datasets: [{
                data: {!! json_encode(array_values($gradeDistribution)) !!},
                backgroundColor: [
                    '#28a745', 
                    '#20c997', 
                    '#17a2b8', 
                    '#007bff', // B
                    '#6610f2', // B-
                    '#ffc107', // C
                    '#fd7e14', // D
                    '#dc3545'  
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });
}
</script>
@endsection