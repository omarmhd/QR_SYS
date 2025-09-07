<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\OnboardingScreen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FeatureController extends Controller
{

    public function index(){
        $features=Feature::all();
        return view("features.index",["features"=>$features]);
    }

    public function create(){
        $feature=new Feature();
        return  view("features.action",['feature'=>$feature]);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name.*' => 'required|max:255',
            'icon' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('icon')) {
            $validated['icon'] = $request->file('icon')->store('features', 'public');
        }
        Feature::create($validated);

        return redirect()->route('features.index')->with('success', 'Feature created successfully.');
    }
    public function edit($id)
    {
        $feature = Feature::findOrFail($id);
        return view('features.action', ["feature"=>$feature]);
    }

    public function update(Request $request, $id)
    {
        $feature= Feature::findOrFail($id);

        $validated = $request->validate([
            'name.*' => 'required|max:255',
            'icon' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('icon')) {
            if ($feature->image) {
                Storage::disk('public')->delete($feature->icon);
            }
            $validated['icon'] = $request->file('icon')->store('features', 'public');
        }

        $feature->update($validated);

        return redirect()->route('features.index')->with('success', 'features updated successfully.');
    }
    public function destroy(Feature $feature)
    {
        if ($feature->icon && Storage::disk('public')->exists($feature->icon)) {
            Storage::disk('public')->delete($feature->icon);
        }

        $feature->delete();

        return redirect()->route('features.index')->with('success', 'feature deleted successfully.');
    }
}
