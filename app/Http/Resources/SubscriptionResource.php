<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $total = $this->plan->guest_passes_per_year ?? 0;
        $coming = $this->last_guests_limit ?? 0;
        $remaining = $total - ($this->used_guests ?? 0);


        return [
            "id" => $this->id,
            "status" => $this->status,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "no_of_guests" => $this->used_guests,
            "total_guest_passes" => $total,
            "coming_guest_passes" => $coming,
            "remaining_guest_passes" => $remaining

        ];
    }
}
