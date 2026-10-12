<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->user()->tasks()->with('subtasks');

        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('priority')) $query->where('priority', $request->priority);
        if ($request->filled('search')) $query->where('title', 'like', '%' . $request->search . '%');

        $tasks = $query->orderBy('created_at', 'desc')->paginate(15);

        return response()->json(['success' => true, 'data' => $tasks]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|max:1000',
            'priority' => 'required|in:low,medium,high',
            'status' => 'nullable|in:pending,in_progress,completed',  // ← اضافه کن
            'due_date' => 'nullable|date',
            'subtasks' => 'nullable|array',
            'subtasks.*' => 'string|max:255',
        ]);

        $task = $request->user()->tasks()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'priority' => $validated['priority'],
            'status' => $validated['status'] ?? 'completed',  // ← پیش‌فرض completed
            'due_date' => $validated['due_date'] ?? null,
        ]);

        if (!empty($validated['subtasks'])) {
            foreach ($validated['subtasks'] as $subtaskTitle) {
                $task->subtasks()->create(['title' => $subtaskTitle]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'وظیفه ایجاد شد.',
            'data' => $task->load('subtasks'),
        ], 201);
    }

    public function show(Request $request, Task $task)
    {
        if ($task->user_id !== $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'دسترسی غیرمجاز.'], 403);
        }
        return response()->json(['success' => true, 'data' => $task->load('subtasks')]);
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'دسترسی غیرمجاز.'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|min:3|max:255',
            'description' => 'nullable|string|max:1000',
            'priority' => 'sometimes|in:low,medium,high',
            'status' => 'sometimes|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
        ]);

        $task->update($validated);

        return response()->json(['success' => true, 'message' => 'وظیفه ویرایش شد.', 'data' => $task->load('subtasks')]);
    }

    public function destroy(Request $request, Task $task)
    {
        if ($task->user_id !== $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'دسترسی غیرمجاز.'], 403);
        }
        $task->delete();
        return response()->json(['success' => true, 'message' => 'وظیفه حذف شد.']);
    }

    public function toggleStatus(Request $request, Task $task)
    {
        if ($task->user_id !== $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'دسترسی غیرمجاز.'], 403);
        }

        $task->status = match($task->status) {
            'pending' => 'in_progress',
            'in_progress' => 'completed',
            'completed' => 'pending',
        };
        $task->save();

        return response()->json(['success' => true, 'message' => 'وضعیت تغییر کرد.', 'data' => $task]);
    }

    public function stats(Request $request)
    {
        $user = $request->user();
        return response()->json([
            'success' => true,
            'data' => [
                'total' => $user->tasks()->count(),
                'pending' => $user->tasks()->where('status', 'pending')->count(),
                'in_progress' => $user->tasks()->where('status', 'in_progress')->count(),
                'completed' => $user->tasks()->where('status', 'completed')->count(),
            ],
        ]);
    }
}
