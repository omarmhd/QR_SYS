<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        $plans=plan::all();
        return view("plans.index",["plans"=>$plans]);

    }

    public function create(){
        $plan=new Plan();
        return view("plans.action",["plan"=>$plan]);
    }

    public function edit(Plan $plan){
        return view("plans.action",compact("plan"));
    }

    public function store(Request $request){
        $validated = $request->validate([
        'name.*' => 'required',
        'price' => 'required|numeric',
        'guest_passes_per_year' => 'required|integer',
        'currency' => 'required|in:EUR,USD',
        'billing_type' => 'required|in:day,month,year',
        'features' => 'required|array|min:1',
        'features.*' => 'required',
    ]);


        $plan = new Plan();
        $plan->name = $request->name;;
        $plan->price = $request->price;
        $plan->guest_passes_per_year = $request->guest_passes_per_year;
        $plan->currency = $request->currency;
        $plan->billing_type = $request->billing_type;
        $plan->is_popular = $request->has('is_popular');
        $plan->features = $request->features;
        $plan->save();

        return redirect()->back()->with('success', 'Plan created successfully');

    }

    public function update(Request $request, Plan $plan)
    {
    $validated = $request->validate([
        'name.*' => 'required',
        'price' => 'required|numeric',
        'guest_passes_per_year' => 'required|integer',
        'currency' => 'required|in:EUR,USD',
        'billing_type' => 'required|in:day,month,year',
        'features' => 'required|array|min:1',
        'features.*' => 'required',
    ]);

    $plan->name = $request->name;
    $plan->price = $request->price;
    $plan->guest_passes_per_year = $request->guest_passes_per_year;
    $plan->currency = $request->currency;
    $plan->billing_type = $request->billing_type;
    $plan->is_popular = $request->has('is_popular');
    $plan->features = $request->features;
    $plan->save();

    return redirect()->back()->with('success', 'Plan updated successfully');
}

    public function destroy(Plan $plan)
{

    $plan->delete();

    return redirect()->route('plans.index')->with('success', 'plan deleted successfully.');
}
}
