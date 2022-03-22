<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BenefitResource extends JsonResource
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
            'benefitTitle' => $this->title,
            'benefitDescription' => $this->description,
            'benefitIndexSort' => $this->sortindex,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('benefits.show', $this->id)
                ],
            ]
        ];
    }
}
