<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        $User = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password
        ]);
        return response()->json([
            'api'=> $User->createToken('Api Token')->plainTextToken
        ]);
    }
    public function login(LoginRequest $request){
        $user = User::where('email' , $request->email)->first();
        if(!$user || !Hash::check($request->password,$user->password)){
            return response()->json([
                'status'=>'Email Or Password Not Correct'
            ]);
        }
        return response()->json([
            'api'=> $user->createToken('Api Token')->plainTextToken
        ]);
    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status'=>'success',
            'message'=>'logged out'
        ]);
    }
}
