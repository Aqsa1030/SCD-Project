<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
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

        $courses = Course::whereHas('semester', function($q) {
            $q->where('user_id', Auth::id())
              ->where('status', 'active');
        })->with('attendances')->get();
        
        $recentAttendances = Attendance::whereHas('course.semester', function($q) {
            $q->where('user_id', Auth::id());
        })->with('course')->orderBy('date', 'desc')->limit(10)->get();
        
        return view('attendance.index', compact('courses', 'recentAttendances'));
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
        
        return view('attendance.create', compact('courses'));
    }

    public function store(Request $request)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late,excused',
            'time' => 'nullable|date_format:H:i',
            'remarks' => 'nullable|string',
        ]);

        $course = Course::find($validated['course_id']);
        if ($course->semester->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }
        $existing = Attendance::where('course_id', $validated['course_id'])
            ->where('date', $validated['date'])
            ->first();
        
        if ($existing) {
            return back()->withErrors(['date' => 'Attendance for this date already exists.'])->withInput();
        }

        Attendance::create($validated);

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance marked successfully!');
    }

    public function edit(Attendance $attendance)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($attendance->course->semester->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this attendance.');
        }

        $courses = Course::whereHas('semester', function($q) {
            $q->where('user_id', Auth::id());
        })->get();

        return view('attendance.edit', compact('attendance', 'courses'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($attendance->course->semester->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this attendance.');
        }

        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late,excused',
            'time' => 'nullable|date_format:H:i',
            'remarks' => 'nullable|string',
        ]);

        $course = Course::find($validated['course_id']);
        if ($course->semester->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $attendance->update($validated);

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance updated successfully!');
    }

    public function destroy(Attendance $attendance)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        if ($attendance->course->semester->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this attendance.');
        }

        $attendance->delete();

        return redirect()->route('attendance.index')
            ->with('success', 'Attendance deleted successfully!');
    }

    public function report()
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $courses = Course::whereHas('semester', function($q) {
            $q->where('user_id', Auth::id());
        })->with('attendances')->get();
        
        $attendanceReport = [];
        
        foreach ($courses as $course) {
            $total = $course->attendances->count();
            $present = $course->attendances->whereIn('status', ['present', 'late'])->count();
            $absent = $course->attendances->where('status', 'absent')->count();
            $late = $course->attendances->where('status', 'late')->count();
            $excused = $course->attendances->where('status', 'excused')->count();
            
            $attendanceReport[] = [
                'course' => $course,
                'total' => $total,
                'present' => $present,
                'absent' => $absent,
                'late' => $late,
                'excused' => $excused,
                'percentage' => $total > 0 ? round(($present / $total) * 100, 2) : 0
            ];
        }
        
        return view('attendance.report', compact('attendanceReport'));
    }
}