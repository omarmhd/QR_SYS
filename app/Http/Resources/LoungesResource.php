<?php

namespace App\Http\Resources;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoungesResource extends JsonResource
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
            "name"=>$this->name[$language],
            "excerpt"=>$this->excerpt[$language],
            "description"=> asset('storage/'.$this->image),
            "open_time"=> $this->open_time,
            "close_time"=> $this->close_time,
            "image"=> asset('storage/'.$this->image),
            "latitude"=> $this->latitude,
            "longitude"=> $this->longitude,
            "terms"=>$this->terms[$language],
            "features"=> $this->features->map(fn($feature) => [
                "id" => $feature->id,
                "name" => $feature->name[$language],
                "icon"=>asset('storage/'.$feature->icon),
            ]),
            "private_services" => Service::all()->map(function($service) use($language) {
                return [
                    "id" => $service->id,
                    "name" => $service->name[$language],
                    "description" => $service->description[$language] ?? null,
                    "icon"=>asset('storage/'.$service->icon) ?? null
                ];
            }),

        ];

    }
}
