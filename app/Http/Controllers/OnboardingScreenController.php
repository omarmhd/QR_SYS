<?php

namespace App\Http\Controllers;

use App\Models\OnboardingScreen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OnboardingScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        $screens=OnboardingScreen::all();
       return view("onboarding_screens.index",["screens"=>$screens]);
    }

    /**
     * Show the form for creating a new resource.
     */
  

      public function create(){

        $screen=new OnboardingScreen(); 
        return view('onboarding_screens.action',["screen"=>$screen]);
    }

    // Store new screen
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title.*' => 'required|max:255',
            'description.*' => 'required',
            'image' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('onboarding', 'public');
        }

        OnboardingScreen::create($validated);

        return redirect()->route('onboarding-screens.index')->with('success', 'Screen created successfully.');
    }

    // Show edit form
    public function edit($id)
    {
        $screen = OnboardingScreen::findOrFail($id);
        return view('onboarding_screens.action', compact('screen'));
    }

    // Update existing screen
    public function update(Request $request, $id)
    {
        $screen = OnboardingScreen::findOrFail($id);

        $validated = $request->validate([
            'title.*' => 'required|max:255',
            'description.*' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($screen->image) {
                Storage::disk('public')->delete($screen->image);
            }

            $validated['image'] = $request->file('image')->store('onboarding', 'public');
        }

        $screen->update($validated);

        return redirect()->route('onboarding-screens.index')->with('success', 'Screen updated successfully.');
    }
    public function destroy(OnboardingScreen $onboardingScreen)
{
    if ($onboardingScreen->image_path && Storage::disk('public')->exists($onboardingScreen->image)) {
        Storage::disk('public')->delete($onboardingScreen->image);
    }

    $onboardingScreen->delete();

    return redirect()->route('onboarding-screens.index')->with('success', 'Screen deleted successfully.');
}
}
