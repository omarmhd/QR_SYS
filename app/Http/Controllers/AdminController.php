<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $admin = auth()->user();
        return view('profile', compact('admin'));
    }

    public function update(Request $request)
    {


        $admin = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|min:6',
        ]);


        $admin->name = $request->name;

        if ($request->filled('password')) {

            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

}
