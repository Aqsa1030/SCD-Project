<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
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

        $grades = Grade::whereHas('course.semester', function($q) {
            $q->where('user_id', Auth::id());
        })->with('course')->latest()->paginate(12);

        return view('grades.index', compact('grades'));
    }

    public function create()
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $courses = Course::whereHas('semester', function($q) {
            $q->where('user_id', Auth::id())
              ->where('status', 'active');
        })->get();

        return view('grades.create', compact('courses'));
    }

    public function store(Request $request)
{
    if ($redirect = $this->checkAuth()) {
        return $redirect;
    }

    $validated = $request->validate([
        'course_id' => 'required|exists:courses,id',
        'title' => 'required|string|max:255',
        'assessment_type' => 'required|in:Quiz,Assignment,Midterm,Final,Project,Presentation,Lab',
        'date' => 'required|date',
        'total_marks' => 'required|numeric|min:0',
        'marks_obtained' => 'nullable|numeric|min:0',
        'weightage' => 'required|numeric|min:0|max:100',
        'status' => 'required|in:pending,completed,graded',
        'remarks' => 'nullable|string',
    ]);

    $course = Course::find($validated['course_id']);
    if ($course->semester->user_id !== Auth::id()) {
        abort(403, 'Unauthorized access.');
    }

    if (isset($validated['marks_obtained']) && $validated['total_marks'] > 0) {
        $validated['percentage'] = ($validated['marks_obtained'] / $validated['total_marks']) * 100;
        $validated['letter_grade'] = $this->calculateLetterGrade($validated['percentage']);
    }

    Grade::create($validated);

    return redirect()->route('grades.index')
        ->with('success', 'Grade added successfully!');
}

    public function show(Grade $grade)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($grade->course->semester->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this grade.');
        }

        return view('grades.show', compact('grade'));
    }

    public function edit(Grade $grade)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($grade->course->semester->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this grade.');
        }

        $courses = Course::whereHas('semester', function($q) {
            $q->where('user_id', Auth::id());
        })->get();

        return view('grades.edit', compact('grade', 'courses'));
    }

    
    public function update(Request $request, Grade $grade)
{
    if ($redirect = $this->checkAuth()) {
        return $redirect;
    }

    if ($grade->course->semester->user_id !== Auth::id()) {
        abort(403, 'Unauthorized access to this grade.');
    }

    $validated = $request->validate([
        'course_id' => 'required|exists:courses,id',
        'title' => 'required|string|max:255',
        'assessment_type' => 'required|in:Quiz,Assignment,Midterm,Final,Project,Presentation,Lab',
        'date' => 'required|date',
        'total_marks' => 'required|numeric|min:0',
        'marks_obtained' => 'nullable|numeric|min:0',
        'weightage' => 'required|numeric|min:0|max:100',
        'status' => 'required|in:pending,completed,graded',
        'remarks' => 'nullable|string',
    ]);

    $course = Course::find($validated['course_id']);
    if ($course->semester->user_id !== Auth::id()) {
        abort(403, 'Unauthorized access.');
    }

    if (isset($validated['marks_obtained']) && $validated['total_marks'] > 0) {
        $validated['percentage'] = ($validated['marks_obtained'] / $validated['total_marks']) * 100;
        $validated['letter_grade'] = $this->calculateLetterGrade($validated['percentage']);
    }

    $grade->update($validated);

    return redirect()->route('grades.index')
        ->with('success', 'Grade updated successfully!');
}

    public function destroy(Grade $grade)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($grade->course->semester->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this grade.');
        }

        $grade->delete();

        return redirect()->route('grades.index')
            ->with('success', 'Grade deleted successfully!');
    }

    public function calculator()
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $courses = Course::whereHas('semester', function($q) {
            $q->where('user_id', Auth::id())
              ->where('status', 'active');
        })->get();

        return view('grades.calculator', compact('courses'));
    }

    private function calculateLetterGrade($percentage)
    {
        if ($percentage >= 85) return 'A';
        if ($percentage >= 80) return 'A-';
        if ($percentage >= 75) return 'B+';
        if ($percentage >= 70) return 'B';
        if ($percentage >= 65) return 'B-';
        if ($percentage >= 60) return 'C+';
        if ($percentage >= 55) return 'C';
        if ($percentage >= 50) return 'C-';
        if ($percentage >= 45) return 'D';
        return 'F';
    }
}