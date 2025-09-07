<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $table="features";
    protected $guarded=[''];
    protected $casts  = ['name' => 'array'];


    public function lounges()
    {
        return $this->belongsToMany(
            Lounge::class,
            'lounge_features',
            'features_id',
            'lounges_id'
        );
    }
}
