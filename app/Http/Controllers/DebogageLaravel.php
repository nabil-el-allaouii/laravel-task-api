<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DebogageLaravel extends Controller
{
    public function store(Request $request){
        if(!$request->user()){
            return response()->json([
                'status'=>'error',
                'message'=>'user unnauthenticated'
            ]);
        }
        $validatedData = $request->validate([
            'title'=>['required','unique:tasks,title'],
            'due_date'=>['required','date']
        ]);

        try{
            $task = new Task();
            $task->title = $validatedData['title'];
            $task->due_date = $validatedData['due_date'];
            $task->user_id = $request->user()->id;
            $task->save();
            return response()->json([
                'status'=>'success',
                'message'=>'task validated and created successfully'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status'=>'failed',
                'message'=>$e->getMessage()
            ]);
        }
    }
}
