<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\Grade;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Check if user is authenticated
     */
    private function checkAuth()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }
        return null;
    }

    /**
     * Get the correct credit column name
     */
    private function getCreditColumnName()
    {
        if (Schema::hasColumn('courses', 'credits')) {
            return 'credits';
        } elseif (Schema::hasColumn('courses', 'credit_hours')) {
            return 'credit_hours';
        } elseif (Schema::hasColumn('courses', 'credit')) {
            return 'credit';
        }
        return 'credits'; // default
    }

    /**
     * Display the transcript.
     */
    public function transcript()
    {
        // Check authentication
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $user = Auth::user();
        $creditColumn = $this->getCreditColumnName();
        
        // Get all semesters with courses and grades
        $semesters = Semester::where('user_id', $user->id)
            ->with(['courses.grades'])
            ->orderBy('start_date', 'asc')
            ->get();
        
        // Calculate overall GPA and total credits
        $totalCredits = 0;
        $totalGradePoints = 0;
        
        foreach ($semesters as $semester) {
            $semesterCredits = 0;
            $semesterGradePoints = 0;
            
            foreach ($semester->courses as $course) {
                // Calculate current grade if not set
                if (!$course->current_grade || $course->current_grade == 0) {
                    $course->calculateCurrentGrade();
                    $course->refresh(); // Reload the model
                }
                
                // Only include courses with valid grades
                if ($course->current_grade && $course->current_grade > 0) {
                    $gradePoint = $course->getGradePoint();
                    $credits = $course->{$creditColumn};
                    
                    $semesterCredits += $credits;
                    $semesterGradePoints += ($gradePoint * $credits);
                    
                    $totalCredits += $credits;
                    $totalGradePoints += ($gradePoint * $credits);
                }
            }
            
            // Calculate semester GPA
            $semester->semester_gpa = $semesterCredits > 0 
                ? round($semesterGradePoints / $semesterCredits, 2) 
                : 0;
            
            $semester->semester_credits = $semesterCredits;
        }
        
        // Calculate cumulative GPA
        $overallGPA = $totalCredits > 0 
            ? round($totalGradePoints / $totalCredits, 2) 
            : 0;
        
        // Determine academic standing
        $academicStanding = 'Needs Improvement';
        if ($overallGPA >= 3.5) {
            $academicStanding = 'Excellent';
        } elseif ($overallGPA >= 3.0) {
            $academicStanding = 'Good Standing';
        } elseif ($overallGPA >= 2.5) {
            $academicStanding = 'Satisfactory';
        }
        
        return view('reports.transcript', compact(
            'user',
            'semesters',
            'overallGPA',
            'totalCredits',
            'academicStanding'
        ));
    }

    /**
     * Display progress report.
     */
    public function progress()
    {
        // Check authentication
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $user = Auth::user();
        $creditColumn = $this->getCreditColumnName();
        
        // Get active semester
        $activeSemester = Semester::where('user_id', $user->id)
            ->orderBy('start_date', 'desc')
            ->first();
        
        if (!$activeSemester) {
            return redirect()->route('semesters.index')
                ->with('error', 'Please create a semester first.');
        }
        
        // Get courses with grades for active semester
        $courses = $activeSemester->courses()
            ->with('grades')
            ->get();
        
        // Calculate current GPA
        $currentGPA = 0;
        $totalCredits = 0;
        $totalGradePoints = 0;
        
        foreach ($courses as $course) {
            if (!$course->current_grade) {
                $course->calculateCurrentGrade();
                $course->refresh();
            }
            
            if ($course->current_grade && $course->current_grade > 0) {
                $gradePoint = $course->getGradePoint();
                $credits = $course->{$creditColumn};
                
                $totalCredits += $credits;
                $totalGradePoints += ($gradePoint * $credits);
            }
        }
        
        $currentGPA = $totalCredits > 0 ? round($totalGradePoints / $totalCredits, 2) : 0;
        
        // Calculate target GPA (example: 3.5)
        $targetGPA = 3.5;
        
        return view('reports.progress', compact(
            'user',
            'activeSemester',
            'courses',
            'currentGPA',
            'targetGPA',
            'totalCredits'
        ));
    }

    /**
     * Generate PDF Transcript
     */
    public function generatePDF()
    {
        // Check authentication
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $user = Auth::user();
        $creditColumn = $this->getCreditColumnName();
        
        // Get all semesters with courses and grades
        $semesters = Semester::where('user_id', $user->id)
            ->with(['courses.grades'])
            ->orderBy('start_date', 'asc')
            ->get();
        
        // Calculate overall GPA and total credits
        $totalCredits = 0;
        $totalGradePoints = 0;
        
        foreach ($semesters as $semester) {
            $semesterCredits = 0;
            $semesterGradePoints = 0;
            
            foreach ($semester->courses as $course) {
                // Calculate current grade if not set
                if (!$course->current_grade || $course->current_grade == 0) {
                    $course->calculateCurrentGrade();
                    $course->refresh();
                }
                
                // Only include courses with valid grades
                if ($course->current_grade && $course->current_grade > 0) {
                    $gradePoint = $course->getGradePoint();
                    $credits = $course->{$creditColumn};
                    
                    $semesterCredits += $credits;
                    $semesterGradePoints += ($gradePoint * $credits);
                    
                    $totalCredits += $credits;
                    $totalGradePoints += ($gradePoint * $credits);
                }
            }
            
            // Calculate semester GPA
            $semester->semester_gpa = $semesterCredits > 0 
                ? round($semesterGradePoints / $semesterCredits, 2) 
                : 0;
            
            $semester->semester_credits = $semesterCredits;
        }
        
        // Calculate cumulative GPA
        $overallGPA = $totalCredits > 0 
            ? round($totalGradePoints / $totalCredits, 2) 
            : 0;
        
        // Determine academic standing
        $academicStanding = 'Needs Improvement';
        if ($overallGPA >= 3.5) {
            $academicStanding = 'Excellent';
        } elseif ($overallGPA >= 3.0) {
            $academicStanding = 'Good Standing';
        } elseif ($overallGPA >= 2.5) {
            $academicStanding = 'Satisfactory';
        }
        
        // Generate PDF
        $pdf = Pdf::loadView('reports.transcript-pdf', compact(
            'user',
            'semesters',
            'overallGPA',
            'totalCredits',
            'academicStanding'
        ));
        
        // Download PDF
        return $pdf->download('transcript-' . $user->name . '-' . date('Y-m-d') . '.pdf');
    }
}