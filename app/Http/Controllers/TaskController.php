<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = Task::where('user_id', $request->user()->id)->get();
        if (!$tasks) {
            return response()->json([
                'message' => 'you have no tasks'
            ]);
        }
        return response()->json([
            'message' => 'Success',
            'data' => $tasks
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'user_id' => $request->user()->id
        ]);
        return response()->json([
            'status' => 'success',
            'task' => $task,
        ],201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskUpdateRequest $request, string $id)
    {
        $task = Task::where('id', $id)->first();
        if (!$task) {
            return response()->json([
                'status' => 'No Task Found'
            ]);
        }
        $task->fill($request->only(['title', 'description', 'due_date', 'status']));
        $task->save();
        return response()->json([
            'status' => 'success',
            'task' => $task
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        $task = $request->user()->tasks->where('id', $id)->first();
        if (!$task) {
            return response()->json([
                'message' => 'No Task To Delete'
            ]);
        }
        $task->delete();
        return response()->json([
            'status' => 'successfully deleted'
        ]);
    }
}
