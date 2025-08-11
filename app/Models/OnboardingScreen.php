<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnboardingScreen extends Model
{
    protected $fillable=['title','description','image'];
    protected $casts=[
        "title"=>"array",
        "description"=>"array"
    ];
}
