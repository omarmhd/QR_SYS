<?php

namespace App\Http\Controllers;

use App\Models\StaticContent;
use Illuminate\Http\Request;

class StaticContentController extends Controller
{
    public function edit(){

        $contents=StaticContent::select("key", "title", "content")
    ->get()
    ->mapWithKeys(function ($item) {
        return [
            $item->key => [
                'title' => $item->title,
                'content' => $item->content,
            ]
        ];
    });


;
        return view("static_content.action",["contents"=>$contents]);

    }

    public function update(Request $request){



        foreach($request->pages as $key=>$content){

            StaticContent::where("key",$key)->update([
                "title"=>$request->titles[$key],
                "content"=>$content
            ]);
        }
       return back()->with('success', 'Pages updated successfully');



    }
}
