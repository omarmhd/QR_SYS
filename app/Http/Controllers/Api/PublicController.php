<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoungesResource;
use App\Http\Resources\OnboardingScreenResource;
use App\Http\Resources\PlanResource;
use App\Http\Resources\StaticContentResource;
use App\Models\Lounge;
use App\Models\Notification;
use App\Models\OnboardingScreen;
use App\Models\Plan;
use App\Models\ServiceRequest;
use App\Models\StaticContent;
use App\Models\ContactMessage;
use App\Models\VisitHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use function Pest\ArchPresets\name;

class PublicController extends Controller
{
    public function onBoardingScreen(Request $request){

        $language = $request->header('Accept-Language', 'en');

        $screens=OnboardingScreen::all();

        if($screens->isEmpty()){
            return response()->json([
                "status"=>false,
                "data"=>[],
                'message' => 'No screens found',

            ], 200);
        }
        return response()->json(["status"=>true,"data"=>OnboardingScreenResource::collection($screens)]);
    }


    public function plans(){
           $plans=Plan::all();

        if($plans->isEmpty()){
            return response()->json([
                "status"=>false,
                'message' => 'No screens found',
                "data"=>[]

            ], 200);
        }


        return response()->json(["status"=>true,"data"=>PlanResource::collection($plans)]);

    }

    public function staticContent(){
        $contents = StaticContent::all();
        if($contents->isEmpty()){
            return response()->json([
                "status"=>false,
                "data"=>[],
                'message' => 'No contents found',

            ], 200);
        }
//       $contents = StaticContent::select("key", "title", "content")
//    ->get()
//    ->mapWithKeys(function ($item) {
//        return [
//            $item->key => [
//                'title' => $item->title,
//                'content' => $item->content,
//            ]
//        ];
//    });

        return response()->json(["status"=>true,"data"=>StaticContentResource::collection($contents)]);

    }

    public function lounges(){
        $lounges=Lounge::all();
        if($lounges->isEmpty()){
            return response()->json([
                "status"=>false,
                "data"=>[],
                'message' => 'No lounges found',

            ], 200);
        }
        return response()->json(["status"=>true,"data"=>LoungesResource::collection($lounges)]);

    }

    public function notifications(){
        $notifications=auth()->user()->notifications;
        if($notifications->isEmpty()){
            return response()->json([
                "status"=>false,
                "data"=>[],
                'message' => 'No notifications found',

            ], 200);
        }
        return response()->json(["status"=>true,"data"=>$notifications]);
    }
    public function storePrivateService(Request $request){
        $fields = $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'full_name'=>"required|string",
            "booking_date"=>"required|date",
            "booking_time"=>"required",
            "guest_number"=>"required",
            "cigar_type"=>"nullable",
            'notes' => 'nullable'

        ]);
        $service=ServiceRequest::create($fields);
        app("firestore")->incrementField('count_vip', +1);

        $messageBody = "New Private Service Request\n\n"
            . "Full Name: {$fields['full_name']}\n"
            . "Service : {$service->name}\n"
            . "Booking Date: {$fields['booking_date']}\n"
            . "Booking Time: {$fields['booking_time']}\n"
            . "Number of Guests: {$fields['guest_number']}\n"
            . "Cigar Type: " . ($fields['cigar_type'] ?? 'N/A') . "\n"
            . "Notes: " . ($fields['notes'] ?? 'None') . "\n\n"
            . "This request was submitted from the App .";

        Mail::raw($messageBody, function ($message) {
            $message->to('omarmhd19988@gmail.com')
            ->subject('New Private Service Request');
        });

        return response()->json(["status"=>true,"message"=>"Your request has been sent successfully"]);

    }
    public function storeContactMessages(Request $request){
        $validated = $request->validate([
            "email"=>"required|email",
            "phone"=>"required",
            'title' => 'required',
            'message' => 'required',
            "user_name"=>"required"


        ]);
//        $user=auth()->user() ?? null;


        $contactMessage=new ContactMessage();
        $contactMessage->user_id=null;
        $contactMessage->user_name=$validated["user_name"];
        $contactMessage->email=$validated["email"];
        $contactMessage->phone=$validated["phone"];
        $contactMessage->title=$validated["title"];
        $contactMessage->message=$validated["message"];
        $contactMessage->save();

        app("firestore")->incrementField('count_messages', +1);

        return response()->json(["status"=>true,"message"=>"Your request has been sent successfully"]);
    }
    public function visitHistories(){
        $histories=auth()->user()->visitHistories;
        if($histories->isEmpty()){
            return response()->json([
                "status"=>false,
                "data"=>[],
                'message' => 'No histories found',

            ], 200);
        }
        return response()->json(["status"=>true,"data"=>$histories]);
    }




}

