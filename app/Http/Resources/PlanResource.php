<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $language = $request->header('Accept-Language', 'en');

        return [
            "id"=>$this->id,
            "name"=>$this->name[$language],
            "price"=>$this->price??0,
            "is_price_hidden"=>$this->is_price_hidden?true:false,
            "currency"=>$this->currency,
            "billing_type"=>$this->billing_type,
            "is_popular"=>$this->is_popular,
            "features"=>$this->features[$language],
            "guest_passes_per_year"=>$this->guest_passes_per_year,

        ];    }
}
