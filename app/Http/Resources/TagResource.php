<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
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
            'tagTitle' => $this->title,
            'tagProgress' => $this->progress,
            // 'tagActivities' => ActivityResource::collection($this->whenLoaded('activities')),
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('tags.show', $this->id)
                ],
                [
                    'rel' => 'tags.activities',
                    'href' => route('tags.activities.index', $this->id)
                ],
            ]
        ];
    }
}
