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
use Illuminate\Http\Request;
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

            ], 404);
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

            ], 404);
        }


        return response()->json(["status"=>true,"data"=>PlanResource::collection($plans)]);

    }

    public function staticContent(){
        $contents = StaticContent::all();

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
        return response()->json(["status"=>true,"data"=>LoungesResource::collection($lounges)]);

    }

    public function notifications(){

        return response()->json(auth()->user()->notifications);
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
        ServiceRequest::create($fields);
        return response()->json(["status"=>true,"message"=>"Your request has been sent successfully"]);

    }
    public function storeContactMessages(Request $request){
        $validated = $request->validate([
            'title' => 'required',
            'message' => 'required',

        ]);
        $user=auth()->user();


        $contactMessage=new ContactMessage();
        $contactMessage->user_id=$user->id;
        $contactMessage->user_name=$user->name;
        $contactMessage->title=$validated["title"];
        $contactMessage->message=$validated["message"];
        $contactMessage->save();




        return response()->json(["status"=>true,"message"=>"Your request has been sent successfully"]);




    }





}

