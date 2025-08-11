<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaticContentResource extends JsonResource
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
            $this->key=> ["title"=> $this->title[$language],
                    "content"=>$this->content[$language]]];
    }
}
