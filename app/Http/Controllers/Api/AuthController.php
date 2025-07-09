<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            "airport"=>"required",
            'phone'=>"required",
            "dob"=>"required|date",
            "plan_id"=>"nullable",
            "plan_name"=>"nullable",

        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'airport' => $fields['airport'],
            "phone"=>$fields['phone'],
            'dob' => $fields['dob'],
            'plan_id' => $fields['plan_id'],
            'plan_name' => $fields['plan_name'],

        ]);


        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request){
        $fields=$request->validate([
            'phone'=>"required"
        ]);

    $user=User::where("approval_status","accepted")->where("phone",$fields["phone"])->first();
        if (!$user) {
        return response()->json([
            'message' => 'User not found or not approved'
        ], 404);
    }
    
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'user' => $user,
        'token' => $token
    ]);

    }

public function logout(Request $request)
{
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'message' => 'Logged out successfully'
    ]);
}
}
