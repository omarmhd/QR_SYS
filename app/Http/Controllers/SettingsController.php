<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function index(){

        $settings=DB::table("settings")->get();
        return view("settings",compact("settings"));
    }
    public function update(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            DB::table('settings')
                ->updateOrInsert(['key' => $key], ['value' => $value]);
        }

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
