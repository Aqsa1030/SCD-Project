<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    private function checkAuth()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }
        return null;
    }

    public function edit()
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $user = Auth::user();
        
        // Calculate statistics
        $totalSemesters = Semester::where('user_id', $user->id)->count();
        
        $totalCourses = Course::whereHas('semester', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();
        
        // Calculate overall GPA
        $courses = Course::whereHas('semester', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();

        $totalGradePoints = 0;
        $totalCredits = 0;

        foreach ($courses as $course) {
            if ($course->current_grade && $course->current_grade > 0) {
                $gradePoint = $course->getGradePoint();
                if ($gradePoint > 0) {
                    $credits = $course->credits ?? $course->credit_hours ?? $course->credit ?? 3;
                    $totalGradePoints += $gradePoint * $credits;
                    $totalCredits += $credits;
                }
            }
        }

        $overallGPA = $totalCredits > 0 ? round($totalGradePoints / $totalCredits, 2) : 0;

        return view('profile.edit', compact(
            'user',
            'totalSemesters',
            'totalCourses',
            'overallGPA'
        ));
    }

    public function update(Request $request)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'student_id' => 'nullable|string|max:50',
            'degree' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:500',
        ]);

        Auth::user()->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = Auth::user();

        // Check current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    public function destroy(Request $request)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $request->validate([
            'password' => 'required',
        ]);

        $user = Auth::user();

        // Verify password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password is incorrect.']);
        }

        // Logout
        Auth::logout();

        // Delete user
        $user->delete();

        // Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Account deleted successfully.');
    }
}