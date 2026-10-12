<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subtask;
use Illuminate\Http\Request;

class SubtaskController extends Controller
{
    public function toggle(Request $request, Subtask $subtask)
    {
        if ($subtask->task->user_id !== $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'دسترسی غیرمجاز.'], 403);
        }

        $subtask->is_completed = !$subtask->is_completed;
        $subtask->save();

        return response()->json(['success' => true, 'message' => 'وضعیت تغییر کرد.', 'data' => $subtask]);
    }
}
