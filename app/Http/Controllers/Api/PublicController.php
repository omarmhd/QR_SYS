<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoungesResource;
use App\Http\Resources\OnboardingScreenResource;
use App\Http\Resources\PlanResource;
use App\Http\Resources\StaticContentResource;
use App\Models\Lounge;
use App\Models\OnboardingScreen;
use App\Models\Plan;
use App\Models\ServiceRequest;
use App\Models\StaticContent;
use Illuminate\Http\Request;

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

    public function storePrivateService(Request $request){
        $fields = $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'full_name'=>"required|string",
            "booking_date"=>"required|date",
            "guest_number"=>"required",
            "cigar_type"=>"nullable",
            'notes' => 'nullable'

        ]);
        ServiceRequest::create($fields);
        return response()->json(["status"=>true,"message"=>"Your request has been sent successfully"]);

    }

}

