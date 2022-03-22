<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'categoryTitle' => $this->title,
            'categoryColor' => $this->color,
            'categoryIcon' => $this->icon,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('categories.show', $this->id)
                ],
                [
                    'rel' => 'categories.blogs',
                    'href' => route('categories.blogs.index', $this->id)
                ],
            ]
        ];
    }
}
