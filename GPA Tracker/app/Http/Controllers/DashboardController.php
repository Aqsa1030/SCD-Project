<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Task;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    private function checkAuth()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }
        return null;
    }

    public function index()
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $user = Auth::user();

        // Get statistics
        $totalSemesters = Semester::where('user_id', $user->id)->count();
        
        if (Schema::hasColumn('semesters', 'status')) {
            $activeSemesters = Semester::where('user_id', $user->id)->where('status', 'active')->count();
        } else {
            $activeSemesters = $totalSemesters; // If no status column, all are considered active
        }
        
        $totalCourses = Course::whereHas('semester', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();
        
        $totalGrades = Grade::whereHas('course.semester', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();
        
        $pendingTasks = Task::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
        
        $completedTasks = Task::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $courses = Course::whereHas('semester', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();

        $totalGradePoints = 0;
        $totalCredits = 0;

        foreach ($courses as $course) {
            if ($course->current_grade) {
                $gradePoint = $course->getGradePoint();
                if ($gradePoint > 0) {
                    $credits = $course->credits ?? $course->credit_hours ?? $course->credit ?? 3;
                    $totalGradePoints += $gradePoint * $credits;
                    $totalCredits += $credits;
                }
            }
        }

        $overallGPA = $totalCredits > 0 ? round($totalGradePoints / $totalCredits, 2) : 0;

        $recentGrades = Grade::whereHas('course.semester', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->latest()->limit(5)->get();

        $recentTasks = Task::where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        $totalAttendance = 0;
        $attendanceCount = 0;
        
        foreach ($courses as $course) {
            $percentage = $course->calculateAttendancePercentage();
            if ($percentage > 0) {
                $totalAttendance += $percentage;
                $attendanceCount++;
            }
        }
        
        $averageAttendance = $attendanceCount > 0 ? round($totalAttendance / $attendanceCount, 1) : 0;

        return view('dashboard', compact(
            'user',
            'totalSemesters',
            'activeSemesters',
            'totalCourses',
            'totalGrades',
            'pendingTasks',
            'completedTasks',
            'overallGPA',
            'averageAttendance',
            'recentGrades',
            'recentTasks'
        ));
    }

    public function statistics()
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $user = Auth::user();

        $semesters = Semester::where('user_id', $user->id)
            ->with('courses.grades')
            ->get();

        $statistics = [];

        foreach ($semesters as $semester) {
            $semesterGPA = 0;
            $totalCredits = 0;
            $totalGradePoints = 0;

            foreach ($semester->courses as $course) {
                if ($course->current_grade) {
                    $gradePoint = $course->getGradePoint();
                    if ($gradePoint > 0) {
                        $credits = $course->credits ?? $course->credit_hours ?? $course->credit ?? 3;
                        $totalGradePoints += $gradePoint * $credits;
                        $totalCredits += $credits;
                    }
                }
            }

            $semesterGPA = $totalCredits > 0 ? round($totalGradePoints / $totalCredits, 2) : 0;

            $statistics[] = [
                'semester' => $semester->name,
                'gpa' => $semesterGPA,
                'courses' => $semester->courses->count(),
                'credits' => $totalCredits
            ];
        }

        return response()->json($statistics);
    }
}