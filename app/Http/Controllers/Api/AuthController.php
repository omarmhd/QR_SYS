<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeviceToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'phone'=>"required|unique:users,phone",
            "dob"=>"required|date",
            "plan_id"=>"nullable",
            "plan_name"=>"nullable",
           'fcm_token' => 'required|string',
           'device_id' => 'required|string',
           'device_type' => 'nullable|string'

        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            "phone"=>$fields['phone'],
            'dob' => $fields['dob'],
            'plan_id' => $fields['plan_id'],
            'plan_name' => $fields['plan_name']

        ]);

    $existing = DeviceToken::where('device_id', $fields['device_id'])
    ->where('user_id', '!=', $user->id)
    ->first();

//         if ($existing) {
//     return response()->json([
//         'status' => false,
//         'message' => 'This device is already registered with another email.',
//         ], 409); 
// }

        DeviceToken::updateOrCreate(
            [
                'user_id' => $user->id,
                'device_id' => $fields['device_id'],
            ],
            [
                'fcm_token' => $fields['fcm_token'],
                'device_type' => $fields['device_type'] ?? null,
            ]
        );

        $token = $user->createToken('api_token')->plainTextToken;
        $user['token'] = $token;
        return response()->json([
            "status"=>true,
            'data'=>$user,
            'message'=>"User created successfully"
        ], 201);
    }

    public function login(Request $request)
{
    $fields = $request->validate([
        'phone' => 'required|string',
        'fcm_token' => 'required|string',
        'device_id' => 'required|string',
        'device_type' => 'nullable|string',
    ]);

    $user = User::where("phone", $fields["phone"])->first();

    if (!$user) {
        return response()->json([
            "status"=>false,
            "data"=>[],
            'message' => 'User not found'
        ], 404);
    }


//     if ($this->hasExceededDeviceLimit($user->id,$request->device_id)) {
//     return response()->json([
//         "status" => false,
//         "data" => [],
//         "message" => "You have reached the maximum number of allowed devices"
//     ], 403);
// }

    $token = $user->createToken('auth_token')->plainTextToken;

    DeviceToken::updateOrCreate(
        [
            'user_id' => $user->id,
            'device_id' => $fields['device_id'],
        ],
        [
            'fcm_token' => $fields['fcm_token'],
            'device_type' => $fields['device_type'] ?? null,
        ]
    );

        $user['token'] = $token;
        return response()->json([
            'status' => true,
            "data"=>$user,
            'message' => 'Login successful'
         
        ]);
}

public function logout(Request $request)
{
    $request->validate([
        'device_id' => 'required|string',
    ]);

    $user = Auth::user();

    DeviceToken::where('user_id', $user->id)
        ->where('device_id', $request->device_id)
        ->delete();

    $request->user()->currentAccessToken()->delete();

    return response()->json([
        "status"=>true,
        "data"=>[],
        'message' => 'Logged out and device token removed'
    ]);
}


private function hasExceededDeviceLimit($user_id,$device_id)
{
    $maxDevices = 1;
    $deviceExists = DeviceToken::where('device_id', $device_id)->exists();
    $deviceCount = DeviceToken::where('user_id', $user_id)->count();
    return $deviceCount >= $maxDevices and !$deviceExists ;
}
}
