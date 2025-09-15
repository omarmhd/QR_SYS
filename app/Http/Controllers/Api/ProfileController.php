<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(){
        $user=auth()->user();
         return response()->json($user);
    }

    public function update(Request $request){
        $user=auth()->user();

        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users,email,'.$user->id,
            'phone' => 'required|unique:users,phone,'.$user->id,
            'location'=>'required'

        ]);


        $user->name=$validated["name"];
        $user->email=$validated["email"];
        $user->phone=$validated["phone"];
        $user->location=$validated["location"];
        $user->save();

        return response()->json($user);

    }

}
