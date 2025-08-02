<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OnboardingScreenResource;
use App\Models\OnboardingScreen;
use App\Models\Plan;
use App\Models\StaticContent;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function onBoardingScreen(){
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
        return response()->json([
            "status"=>true,
            'message' => '',
            "data"=>$plans]);
    }

    public function staticContent(){

       $contents = StaticContent::select("key", "title", "content")
    ->get()
    ->mapWithKeys(function ($item) {
        return [
            $item->key => [
                'title' => $item->title,
                'content' => $item->content,
            ]
        ];
    });

        return response()->json(["status"=>true,"data"=>$contents]);

    }

}

