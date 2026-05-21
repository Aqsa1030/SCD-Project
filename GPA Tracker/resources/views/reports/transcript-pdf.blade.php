<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Transcript - {{ $user->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #667eea;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .header h2 {
            color: #764ba2;
            font-size: 20px;
            margin-bottom: 5px;
        }

        .student-info {
            margin-bottom: 30px;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }

        .student-info table {
            width: 100%;
        }

        .student-info td {
            padding: 8px;
        }

        .student-info td:first-child {
            font-weight: bold;
            width: 150px;
        }

        .summary {
            margin-bottom: 30px;
            background: #667eea;
            color: white;
            padding: 20px;
            border-radius: 8px;
        }

        .summary table {
            width: 100%;
            color: white;
        }

        .summary td {
            padding: 10px;
            font-size: 14px;
        }

        .summary td:first-child {
            font-weight: bold;
        }

        .summary .gpa {
            font-size: 32px;
            font-weight: bold;
            text-align: center;
        }

        .semester {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .semester-header {
            background: #764ba2;
            color: white;
            padding: 12px 20px;
            border-radius: 8px 8px 0 0;
            font-size: 16px;
            font-weight: bold;
        }

        .courses-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .courses-table th {
            background: #f8f9fa;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #dee2e6;
            font-weight: bold;
        }

        .courses-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #dee2e6;
        }

        .courses-table tr:last-child td {
            border-bottom: none;
        }

        .semester-footer {
            background: #f8f9fa;
            padding: 12px 20px;
            border-radius: 0 0 8px 8px;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #6c757d;
            border-top: 2px solid #dee2e6;
            padding-top: 20px;
        }

        .grade-excellent {
            color: #10b981;
            font-weight: bold;
        }

        .grade-good {
            color: #3b82f6;
            font-weight: bold;
        }

        .grade-average {
            color: #f59e0b;
            font-weight: bold;
        }

        .grade-poor {
            color: #ef4444;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ACADEMIA GPA TRACKER</h1>
        <h2>Official Academic Transcript</h2>
        <p>Generated on: {{ date('F d, Y') }}</p>
    </div>

    <div class="student-info">
        <table>
            <tr>
                <td>Student Name:</td>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <td>Email:</td>
                <td>{{ $user->email }}</td>
            </tr>
            @if($user->student_id)
            <tr>
                <td>Student ID:</td>
                <td>{{ $user->student_id }}</td>
            </tr>
            @endif
            @if($user->degree)
            <tr>
                <td>Degree Program:</td>
                <td>{{ $user->degree }}</td>
            </tr>
            @endif
            @if($user->department)
            <tr>
                <td>Department:</td>
                <td>{{ $user->department }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="summary">
        <table>
            <tr>
                <td style="width: 70%;">
                    <div style="margin-bottom: 10px;">
                        <strong>Cumulative GPA:</strong>
                        <div class="gpa">{{ number_format($overallGPA, 2) }}</div>
                    </div>
                </td>
                <td style="text-align: right;">
                    <div><strong>Total Credits:</strong> {{ $totalCredits }}</div>
                    <div><strong>Total Semesters:</strong> {{ $semesters->count() }}</div>
                </td>
            </tr>
        </table>
    </div>

    @foreach($semesters as $semester)
    <div class="semester">
        <div class="semester-header">
            {{ $semester->name }} {{ $semester->year }}
            <span style="float: right;">
                {{ $semester->start_date->format('M Y') }} - {{ $semester->end_date->format('M Y') }}
            </span>
        </div>

        @if($semester->courses->count() > 0)
        <table class="courses-table">
            <thead>
                <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th style="text-align: center;">Credits</th>
                    <th style="text-align: center;">Grade</th>
                    <th style="text-align: center;">Points</th>
                </tr>
            </thead>
            <tbody>
                @foreach($semester->courses as $course)
                <tr>
                    <td>{{ $course->code }}</td>
                    <td>{{ $course->name }}</td>
                    <td style="text-align: center;">{{ $course->credits }}</td>
                    <td style="text-align: center;">
                        @if($course->grades->count() > 0)
                            @php
                                $grade = $course->grades->first();
                                $gradeClass = '';
                                if ($grade->grade_point >= 3.5) $gradeClass = 'grade-excellent';
                                elseif ($grade->grade_point >= 3.0) $gradeClass = 'grade-good';
                                elseif ($grade->grade_point >= 2.0) $gradeClass = 'grade-average';
                                else $gradeClass = 'grade-poor';
                            @endphp
                            <span class="{{ $gradeClass }}">{{ $grade->letter_grade }}</span>
                        @else
                            <span style="color: #6c757d;">-</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @if($course->grades->count() > 0)
                            {{ number_format($course->grades->first()->grade_point, 2) }}
                        @else
                            <span style="color: #6c757d;">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="semester-footer">
            <span>Semester GPA: <strong>{{ number_format($semester->gpa, 2) }}</strong></span>
            <span style="float: right;">Total Credits: <strong>{{ $semester->totalCredits }}</strong></span>
        </div>
        @else
        <div style="padding: 20px; text-align: center; color: #6c757d; background: #f8f9fa;">
            No courses recorded for this semester
        </div>
        @endif
    </div>
    @endforeach

    
</body>
</html>