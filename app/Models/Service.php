<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded=[''];
    protected $casts=[
        "name"=>"array",
        "description"=>"array"
    ];


    public function service_requests(){
        return $this->hasMany(ServiceRequest::class);

    }
}
