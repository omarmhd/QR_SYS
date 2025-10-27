<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ServiceRequestController extends Controller
{

    public function index(Request $request){
        $service=Service::findOrFail($request->service_id);
        $service_name=$service->name;
        if ($request->ajax()) {

            $service_requests = ServiceRequest::where("service_id", $request->service_id);


            return DataTables::of($service_requests)
           ->addColumn('actions', function ($row) {
                    $route_delete = route("service-requests.destroy", $row);
                    $csrf_token = csrf_token();

                    return <<<btns
                              <form class="delete-form" action="{$route_delete}" method="POST" style="display:inline-block;">
                                <input type="hidden" name="_token" value="{$csrf_token}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-icon delete-btn" aria-label="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                          <path d="M4 7l16 0"></path>
                          <path d="M10 11l0 6"></path>
                          <path d="M14 11l0 6"></path>
                          <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                          <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                        </svg>
                                </button>
                            </form>
                    btns;
                })->rawColumns(['actions'])
                ->make(true);
        }




        return view("service_requests.index",["service_name"=>$service_name]);



    }

    public function destroy(ServiceRequest $serviceRequest)
    {

        $serviceRequest->delete();
        app("firestore")->incrementField('count_vip',-1);

        return redirect()->back()->with('success', ' deleted successfully.');
    }}
