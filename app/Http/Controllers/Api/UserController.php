<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //Handle Auth Logic
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email|max:255',
            'password' => 'required',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->plainTextToken;
            return response()->json([
                'message' => 'Logged in successfully',
                'user' => $user,
                'token' => $token
            ], 200);
        }
        return response()->json([
            'message' => 'Login unsuccessful, invalid credentials'
        ], 401);
    }
 
    public function logout(Request $request){
        $user = Auth::User();
        if($user){
            $user->currentAccessToken()->delete();
            //to remove all tokens
            // $user->tokens()->delete();
            return response()->json([
                'message' => 'User logged out',
            ], 200);
        }
        return response()->json([
            'message' => 'No user found',
        ], 404);
    }
 
    //Simple API Creation
     
    public function index(){
        $users = User::all();
        if($users->count() == 0)
        {
            return response()->json([
                'message' => 'No users found',
            ], 404);
        }
        return response()->json([
            'message' => 'All users found',
            'users' => $users
        ], 200);
    }
 
    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'email|required|max:255',
            'password' => 'required',
        ]);
        $user = new User;
        $user-> name = $request['name'];
        $user-> email = $request['email'];
        $user-> password = Hash::make($request['password']);
        $user-> save();
        return response()->json([
            'message' => 'User created successfully',
            'user_details' => $user
        ], 201);
     }
 
    public function show($id){
        $user = User::find($id);
        if($user){
            return response()->json([
                'message' => 'User found',
                'user' => $user
            ], 200);
        }
        return response()->json([
            'message' => 'No User found',
        ], 404);
    }
 
    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:8',
        ]);
        $user = User::find($id);
        if($user){
            $user->update([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password'])
            ]);
            return response()->json([
                'message' => 'User updated successfully',
                'user' => $user
            ], 200);
        }
        return response()->json([
            'message' => 'No User found',
        ], 404);
    }
 
    public function destroy(Request $request, $id){
        $user = User::find($id);
        if($user){
            $user->delete();
            return response()->json([
                'message' => 'User deleted successfully',
            ], 200);
        }
        return response()->json([
            'message' => 'User not found',
        ], 404);
    }
}
