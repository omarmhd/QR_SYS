<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Services\FcmNotificationService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NotificationController extends Controller
{

    protected $firebaseService;

    public function __construct(FcmNotificationService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }
    public function index(Request $request){

        if($request->ajax()){
            $notification = Notification::query()->orderBy('id', 'desc');;
            return DataTables::of($notification)
                ->make(true);
        }

        return view('notifications.index');

    }

    public function create(){

        return view('notifications.action');
    }

    public function store(Request $request){

        $validated = $request->validate([
            'title.*' => 'required|string|max:255',
            'body.*' => 'required|string'
        ]);
        $response=$this->firebaseService->sendNotification('general', $validated["title"], $validated["body"], ["type" => "topic"], null, 'topic');
         if(!isset($response[0]['name'])){
            return redirect()->back()->with("error","Error in send notification");
         }

        return redirect()->route("notifications.index")->with("success","");

     }





    }







