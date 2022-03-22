<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'identifier' => $this->id,
            'offerTitle' => $this->title,
            'offerDescription' => $this->description,
            'offerIcon' => $this->icon,
            'offerIndexIcon' => $this->indexicon,
            'offerIndexSort' => $this->sortindex
        ];
    }
}
