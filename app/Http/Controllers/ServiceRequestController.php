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
        $service=Service::findOrFail($request->service_id);;
        $service_name=$service->name;
        if ($request->ajax()) {

            $service_requests = ServiceRequest::with("user")->where("service_id", $request->service_id)->orderBy('id', 'desc');


            return DataTables::of($service_requests)
            ->addColumn('phone', function ($row) {
                return $row?->user?->phone;

            })->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '';
                })->addColumn('email', function ($row) {
                    return $row?->user?->email;

                })
                ->addColumn('actions', function ($row) {
                    $route_delete = route("service-requests.destroy", $row);
                    $csrf_token = csrf_token();

                    $checkBtn = '';
                    if (!$row->checked) {
                        $checkBtn = <<<btn
            <button class="btn btn-info btn-icon check-btn" data-id="{$row->id}" title="Confirm">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                    <path d="M11.102 17.957c-3.204 -.307 -5.904 -2.294 -8.102 -5.957
                             c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6a19.5 19.5 0 0 1 -.663 1.032" />
                    <path d="M15 19l2 2l4 -4" />
                </svg>
            </button>
        btn;
                    }

                    $notesBtn = <<<btn
        <button class="btn btn-warning btn-icon notes-btn"
                data-id="{$row->id}"
                data-name="{$row->full_name}"
                title="Add Notes">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20h9" />
                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1l1-4L16.5 3.5z" />
            </svg>
        </button>
    btn;

                    return <<<btns
        <form class="delete-form" action="{$route_delete}" method="POST" style="display:inline-block;">
            <input type="hidden" name="_token" value="{$csrf_token}">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger btn-icon delete-btn" aria-label="Delete" title="Delete">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 7h16" />
                    <path d="M10 11v6" />
                    <path d="M14 11v6" />
                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12" />
                    <path d="M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3" />
                </svg>
            </button>
        </form>

        {$checkBtn}
        {$notesBtn}
    btns;
                })->rawColumns(['email','phone','actions','created_at'])
                ->make(true);
        }




        return view("service_requests.index",["service_name"=>$service_name]);



    }
    public function storeNote(Request $request, $id)
    {
        $request->validate(['note' => 'required|string|max:1000']);

        $serviceRequest = ServiceRequest::findOrFail($id);
        $serviceRequest->note = $request->note;
        $serviceRequest->save();

        return response()->json(['message' => 'Note saved successfully']);
    }

    public function destroy(ServiceRequest $serviceRequest)
    {

        $serviceRequest->delete();
        app("firestore")->incrementField('count_vip',-1);

        return redirect()->back()->with('success', ' deleted successfully.');
    }}
