<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Lounge;
use App\Models\OnboardingScreen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LoungeController extends Controller
{
    public  function index(){

        $lounges=Lounge::all();

        return view("lounges.index",["lounges"=>$lounges]);

    }

    public function  create(){
        $lounge=new Lounge();
        $features=Feature::all();

        return view("lounges.action",["lounge"=>$lounge,"features"=>$features]);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name.*' => 'required',
            'excerpt.*' => 'required',
            'description.*' => 'required',
            'terms.*' => 'required',
            'open_time' => 'required',
            'close_time' => 'required',
            "longitude"=>"required",
            "latitude"=>"required",
            'features.*' => 'required',
            'image'=> 'required'
        ]);
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('lounges', 'public');
        }


        $lounge= new Lounge();
        $lounge->name = $request->name;;
        $lounge->excerpt = $request->excerpt;
        $lounge->description = $request->description;
        $lounge->terms = $request->terms;
        $lounge->open_time = $request->open_time;
        $lounge->close_time = $request->close_time;
        $lounge->longitude = $request->longitude;
        $lounge->latitude = $request->latitude;

        $lounge->image = $validated['image'];
        $lounge->save();

        $lounge->features()->attach($validated["features"]);

        return redirect()->route('lounges.index')->with('success', 'Lounges created successfully');


    }

    public function edit(Lounge $lounge){
        $features=Feature::all();
        $lounge_features=$lounge->features->pluck('id')->toArray();

        return view("lounges.action",[
            "lounge"=>$lounge,
            "features"=>$features,
            "lounge_features"=>$lounge_features
        ]);

    }

    public function update(Request $request,Lounge $lounge){
        $validated = $request->validate([
            'name.*' => 'required',
            'excerpt.*' => 'required',
            'description.*' => 'required',
            'terms.*' => 'required',
            'open_time' => 'required',
            'close_time' => 'required',
            "longitude"=>"required",
            "latitude"=>"required",
            "features"=>"array",


        ]);
        if ($request->hasFile('image')) {
            if ($lounge->image) {
                Storage::disk('public')->delete($lounge->image);
            }

            $lounge->image = $request->file('image')->store('lounge', 'public');
        }
        $lounge->name = $request->name;;
        $lounge->excerpt = $request->excerpt;
        $lounge->description = $request->description;
        $lounge->terms = $request->terms;
        $lounge->open_time = $request->open_time;
        $lounge->close_time = $request->close_time;
        $lounge->longitude = $request->longitude;
        $lounge->latitude = $request->latitude;
        $lounge->save();


        $lounge->features()->sync($validated["features"]??[]);

        return redirect()->route('lounges.index')->with('success', 'lounge updated successfully');

    }

    public function destroy(Lounge $lounge)
    {
        if ($lounge->image && Storage::disk('public')->exists($lounge->image)) {
            Storage::disk('public')->delete($lounge->image);
        }

        $lounge->delete();

        return redirect()->route('lounges.index')->with('success', 'lounge deleted successfully');
    }



}
