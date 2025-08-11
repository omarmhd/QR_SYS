<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticContent extends Model
{
    protected $casts=[
        "title"=>"array",
        "content"=>"array"
    ];
}
