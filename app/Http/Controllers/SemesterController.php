<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SemesterController extends Controller
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

        $semesters = Semester::where('user_id', Auth::id())
            ->with('courses')
            ->latest()
            ->get();

        return view('semesters.index', compact('semesters'));
    }

    public function create()
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        return view('semesters.create');
    }

    public function store(Request $request)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            // Don't validate year - it will be auto-generated
        ]);

        // The year will be automatically set by the model's boot method
        $semester = Semester::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            // status and year will be handled automatically
        ]);

        return redirect()->route('semesters.index')
            ->with('success', 'Semester created successfully!');
    }

    public function show(Semester $semester)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Check ownership
        if ($semester->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this semester.');
        }

        $semester->load('courses.grades', 'courses.attendances');

        return view('semesters.show', compact('semester'));
    }

    public function edit(Semester $semester)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Check ownership
        if ($semester->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this semester.');
        }

        return view('semesters.edit', compact('semester'));
    }

    public function update(Request $request, Semester $semester)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Check ownership
        if ($semester->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this semester.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            // Don't validate year - it will be auto-updated
        ]);

        $semester->update($validated);

        return redirect()->route('semesters.index')
            ->with('success', 'Semester updated successfully!');
    }

    public function destroy(Semester $semester)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Check ownership
        if ($semester->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this semester.');
        }

        $semester->delete();

        return redirect()->route('semesters.index')
            ->with('success', 'Semester deleted successfully!');
    }
}