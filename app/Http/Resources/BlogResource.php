<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'blogTitle' => $this->title,
            'blogDescription' => $this->description,
            'blogDescriptionFull' => $this->description_full,
            'blogImages' => $this->images,
            'blogDate' => $this->date,
            'blogCategories' => CategoryResource::collection($this->whenLoaded('categories')),
            'blogEntryCreatedAt' => $this->created_at,
            'blogEntryUpdatedAt' => $this->updated_at,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('blogs.show', $this->id)
                ],
                [
                    'rel' => 'blogs.categories',
                    'href' => route('blogs.categories.index', $this->id)
                ],
                [
                    'rel' => 'blogs.mains',
                    'href' => route('blogs.mains.index', $this->id)
                ],
                [
                    'rel' => 'blogs.sections',
                    'href' => route('blogs.sections.index', $this->id)
                ],
                [
                    'rel' => 'blogs.offers',
                    'href' => route('blogs.offers.index', $this->id)
                ],
                [
                    'rel' => 'blogs.benefits',
                    'href' => route('blogs.benefits.index', $this->id)
                ],
                [
                    'rel' => 'blogs.activities',
                    'href' => route('blogs.activities.index', $this->id)
                ],
                [
                    'rel' => 'blogs.tags',
                    'href' => route('blogs.tags.index', $this->id)
                ],
            ]
        ];
    }
}
