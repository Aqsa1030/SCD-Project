<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
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

        $courses = Course::whereHas('semester', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->with(['semester', 'grades', 'attendances'])
            ->latest()
            ->get();

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }
        $semesters = Semester::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('courses.create', compact('semesters'));
    }

    public function store(Request $request)
{
    if ($redirect = $this->checkAuth()) {
        return $redirect;
    }

    $validated = $request->validate([
        'semester_id' => 'required|exists:semesters,id',
        'course_code' => 'required|string|max:50',  
        'course_name' => 'required|string|max:255', 
        'credit_hours' => 'required|numeric|min:0.5|max:10', 
        'instructor' => 'nullable|string|max:255',
        'instructor_email' => 'nullable|email|max:255',
        'schedule' => 'nullable|string|max:255',
        'room' => 'nullable|string|max:100',
        'target_grade' => 'nullable|numeric|min:0|max:100',
        'color_code' => 'nullable|string|max:7',
        'description' => 'nullable|string',
        'notes' => 'nullable|string',
        'textbook' => 'nullable|string|max:255',
    ]);

    $validated['code'] = $validated['course_code'];
    $validated['name'] = $validated['course_name'];
    $validated['credits'] = $validated['credit_hours'];
    
    unset($validated['course_code']);
    unset($validated['course_name']);
    unset($validated['credit_hours']);

    $semester = Semester::findOrFail($validated['semester_id']);
    if ($semester->user_id !== Auth::id()) {
        abort(403, 'Unauthorized access to this semester.');
    }

    $course = Course::create($validated);

    return redirect()->route('courses.show', $course)
        ->with('success', 'Course created successfully!');
}

    public function show(Course $course)
{
    if ($redirect = $this->checkAuth()) {
        return $redirect;
    }

    if ($course->semester->user_id !== Auth::id()) {
        abort(403, 'Unauthorized access to this course.');
    }

    $course->load(['semester', 'grades' => function ($query) {
        $query->orderBy('date'); 
    }, 'attendances' => function ($query) {
        $query->orderBy('date', 'desc');
    }]);

    return view('courses.show', compact('course'));
}

    public function edit(Course $course)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($course->semester->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }

        $semesters = Semester::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('courses.edit', compact('course', 'semesters'));
    }

    public function update(Request $request, Course $course)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($course->semester->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }

        $validated = $request->validate([
            'semester_id' => 'required|exists:semesters,id',
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'credits' => 'required|numeric|min:0.5|max:10',
            'instructor' => 'nullable|string|max:255',
            'instructor_email' => 'nullable|email|max:255',
            'schedule' => 'nullable|string|max:255',
            'room' => 'nullable|string|max:100',
            'target_grade' => 'nullable|numeric|min:0|max:100',
            'color_code' => 'nullable|string|max:7',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'textbook' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,completed,dropped',
            'current_grade' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validated['semester_id'] != $course->semester_id) {
            $semester = Semester::findOrFail($validated['semester_id']);
            if ($semester->user_id !== Auth::id()) {
                abort(403, 'Unauthorized access to this semester.');
            }
        }

        $course->update($validated);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Course updated successfully!');
    }

    public function destroy(Course $course)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($course->semester->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }

        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully!');
    }

    
    public function calculateGrade(Course $course)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($course->semester->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }

        $currentGrade = $course->calculateCurrentGrade();

        return redirect()->route('courses.show', $course)
            ->with('success', $currentGrade 
                ? "Current grade calculated: {$currentGrade}%" 
                : "No graded assessments found.");
    }

    
    public function calculateAttendance(Course $course)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($course->semester->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this course.');
        }

        $attendancePercentage = $course->calculateAttendancePercentage();

        return redirect()->route('courses.show', $course)
            ->with('success', "Attendance percentage: {$attendancePercentage}%");
    }
}