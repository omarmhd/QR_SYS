<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lounge extends Model
{

    protected $guarded=[''];
    protected $casts  = [
        'name' => 'array',
        "description"=>'array',
        'excerpt'=>'array',
        'terms'=>'array'
    ];

    public function features(){
        return $this->belongsToMany(
            Feature::class,
            "lounge_features",
            "lounges_id",
            "features_id"
        );
    }
}
