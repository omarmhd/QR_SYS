<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index(){
        $services=Service::all();
        return view("services.index",["services"=>$services]);
    }

    public function create(){
        $service=new Service();
        return view("services.action",["service"=>$service]);

    }

    public function store(Request $request){
        $validated = $request->validate([
            'name.*' => 'required',
            'description.*' => 'required',
            'icon' => 'required',

        ]);

        $service=new Service();
        if ($request->hasFile('icon')) {
            $service->icon= $request->file('icon')->store('services', 'public');
        }

        $service->name=$validated["name"];
        $service->description=$validated["description"];
        $service->save();


        return redirect()->route("services.index")->with("success","Service created successfully");
    }

    public function edit(Service $service){
        return view("services.edit",["service"=>$service]);
    }

    public function update(Request $request,Service $service){
        $validated = $request->validate([
            'name.*' => 'required',
            'description.*' => 'required',
            'icon' => 'required',

        ]);
        if ($request->hasFile('icon')) {
            if ($service->icon) {
                Storage::disk('public')->delete($service->icon);
            }
            $service->icon = $request->file('icon')->store('service', 'public');
        }
        $service->name=$validated["name"];
        $service->description=$validated["description"];
        $service->save();


        return redirect()->route("services.index")->with("success","Service created successfully");


    }
    public function destroy(Service $service)
    {
        if ($service->icon && Storage::disk('public')->exists($service->icon)) {
            Storage::disk('public')->delete($service->icon);
        }

        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }


}
