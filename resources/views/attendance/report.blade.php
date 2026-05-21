@extends('layouts.app')

@section('title', 'Attendance Report')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">
                <i class="fas fa-chart-bar text-primary"></i> Attendance Report
            </h1>
            <p class="text-muted mb-0">Comprehensive attendance analysis and statistics</p>
        </div>
        <div>
            <a href="{{ route('attendance.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Back to Attendance
            </a>
        </div>
    </div>

    @if(count($attendanceReport) > 0)
    
    <div class="row g-4 mb-4">
        @php
            $overallTotal = collect($attendanceReport)->sum('total');
            $overallPresent = collect($attendanceReport)->sum('present');
            $overallAbsent = collect($attendanceReport)->sum('absent');
            $overallPercentage = $overallTotal > 0 ? round(($overallPresent / $overallTotal) * 100, 2) : 0;
        @endphp
        <div class="col-md-3">
            <div class="card stat-card text-center">
                <div class="card-body">
                    <i class="fas fa-calendar fa-3x text-primary mb-3"></i>
                    <h2>{{ $overallTotal }}</h2>
                    <p class="text-muted mb-0">Total Classes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card text-center" style="border-left-color: #06d6a0;">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <h2>{{ $overallPresent }}</h2>
                    <p class="text-muted mb-0">Present</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card text-center" style="border-left-color: #ef476f;">
                <div class="card-body">
                    <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                    <h2>{{ $overallAbsent }}</h2>
                    <p class="text-muted mb-0">Absent</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card text-center" style="border-left-color: #ffd60a;">
                <div class="card-body">
                    <i class="fas fa-percentage fa-3x text-warning mb-3"></i>
                    <h2>{{ number_format($overallPercentage, 1) }}%</h2>
                    <p class="text-muted mb-0">Overall Rate</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-list"></i> Course-wise Attendance</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Total Classes</th>
                            <th>Present</th>
                            <th>Absent</th>
                            <th>Late</th>
                            <th>Excused</th>
                            <th>Percentage</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendanceReport as $report)
                        <tr>
                            <td>
                                <strong>{{ $report['course']->course_name }}</strong><br>
                                <small class="text-muted">{{ $report['course']->course_code }}</small>
                            </td>
                            <td><strong>{{ $report['total'] }}</strong></td>
                            <td class="text-success"><strong>{{ $report['present'] }}</strong></td>
                            <td class="text-danger"><strong>{{ $report['absent'] }}</strong></td>
                            <td class="text-warning"><strong>{{ $report['late'] }}</strong></td>
                            <td class="text-info"><strong>{{ $report['excused'] }}</strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1 me-2" style="height: 8px; width: 100px;">
                                        <div class="progress-bar bg-{{ $report['percentage'] >= 75 ? 'success' : 'danger' }}" 
                                             style="width: {{ $report['percentage'] }}%">
                                        </div>
                                    </div>
                                    <strong>{{ number_format($report['percentage'], 1) }}%</strong>
                                </div>
                            </td>
                            <td>
                                @if($report['percentage'] >= 85)
                                    <span class="badge bg-success">Excellent</span>
                                @elseif($report['percentage'] >= 75)
                                    <span class="badge bg-primary">Good</span>
                                @elseif($report['percentage'] >= 60)
                                    <span class="badge bg-warning">Fair</span>
                                @else
                                    <span class="badge bg-danger">Low</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row g-4 mt-2">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-chart-pie"></i> Attendance Distribution</h6>
                </div>
                <div class="card-body">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-chart-bar"></i> Course Comparison</h6>
                </div>
                <div class="card-body">
                    <canvas id="courseChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-chart-bar fa-4x text-muted mb-4"></i>
            <h4 class="mb-3">No Attendance Data</h4>
            <p class="text-muted mb-4">Start marking attendance to see detailed reports.</p>
            <a href="{{ route('attendance.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus"></i> Mark Attendance
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
@if(count($attendanceReport) > 0)
<script>
const attendanceCtx = document.getElementById('attendanceChart');
if(attendanceCtx) {
    new Chart(attendanceCtx, {
        type: 'doughnut',
        data: {
            labels: ['Present', 'Absent', 'Late', 'Excused'],
            datasets: [{
                data: [
                    {{ $overallPresent }},
                    {{ $overallAbsent }},
                    {{ collect($attendanceReport)->sum('late') }},
                    {{ collect($attendanceReport)->sum('excused') }}
                ],
                backgroundColor: ['#06d6a0', '#ef476f', '#ffd60a', '#4cc9f0'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

const courseCtx = document.getElementById('courseChart');
if(courseCtx) {
    new Chart(courseCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(collect($attendanceReport)->pluck('course.course_code')) !!},
            datasets: [{
                label: 'Attendance %',
                data: {!! json_encode(collect($attendanceReport)->pluck('percentage')) !!},
                backgroundColor: 'rgba(67, 97, 238, 0.8)',
                borderColor: 'rgba(67, 97, 238, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
}
</script>
@endif
@endsection