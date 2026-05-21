<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
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

        $pendingTasks = Task::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->with('course')
            ->orderBy('due_date')
            ->get();

        $inProgressTasks = Task::where('user_id', Auth::id())
            ->where('status', 'in_progress')
            ->with('course')
            ->orderBy('due_date')
            ->get();

        $completedTasks = Task::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->with('course')
            ->latest()
            ->get();

        return view('tasks.index', compact('pendingTasks', 'inProgressTasks', 'completedTasks'));
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

        return view('tasks.create', compact('courses'));
    }

    public function store(Request $request)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'nullable|exists:courses,id',
            'due_date' => 'required|date',
            'due_time' => 'nullable|date_format:H:i',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        // Verify course ownership if course_id provided
        if (isset($validated['course_id'])) {
            $course = Course::find($validated['course_id']);
            if ($course->semester->user_id !== Auth::id()) {
                abort(403, 'Unauthorized access.');
            }
        }

        $validated['user_id'] = Auth::id();
        $validated['progress'] = $validated['progress'] ?? 0;

        Task::create($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully!');
    }

    public function show(Task $task)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Check ownership
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this task.');
        }

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Check ownership
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this task.');
        }

        $courses = Course::whereHas('semester', function($q) {
            $q->where('user_id', Auth::id());
        })->get();

        return view('tasks.edit', compact('task', 'courses'));
    }

    public function update(Request $request, Task $task)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Check ownership
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this task.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'nullable|exists:courses,id',
            'due_date' => 'required|date',
            'due_time' => 'nullable|date_format:H:i',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'progress' => 'nullable|integer|min:0|max:100',
        ]);

        // Verify course ownership if course_id provided
        if (isset($validated['course_id'])) {
            $course = Course::find($validated['course_id']);
            if ($course->semester->user_id !== Auth::id()) {
                abort(403, 'Unauthorized access.');
            }
        }

        $task->update($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Check ownership
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this task.');
        }

        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully!');
    }

    public function complete(Task $task)
    {
        if ($redirect = $this->checkAuth()) {
            return $redirect;
        }

        // Check ownership
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this task.');
        }

        $task->update([
            'status' => 'completed',
            'progress' => 100,
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Task marked as completed!');
    }
}