<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(){
        $user=auth()->user;
         return response()->json($user);
    }

//    public function update(Request $request){
//
//        $table->id();
//        $table->string('name');
//        $table->string('email')->unique();
//        $table->string('phone')->unique();
//        $table->timestamp('verified_at')->nullable();
//        $table->string("dob");
//        $table->foreignId("plan_id")->nullable()->constrained("plans");
//        $table->string("plan_name")->nullable();
//        $table->enum("approval_status",["pending","accepted","rejected"]);
//        $table->boolean("subscription_status")->default(0);
//        $table->rememberToken();
//        $user=auth()->user;
//        $validated = $request->validate([
//            'name' => 'required|max:255',
//            'email' => 'required|unique:users,email.'.$user->id,
//            'phone' => 'required|unique:users,phone.'.$user->id,
//        ]);
//
//
//    }

}
