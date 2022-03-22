<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
            'activityTitle' => $this->title,
            'activitySubtitle' => $this->subtitle,
            'activityImage' => $this->image,
            'activitySectionTitle1' => $this->section_title_1,
            'activitySectionDescription1' => $this->section_description_1,
            'activitySectionType1' => $this->section_type_1,
            'activitySectionTitle2' => $this->section_title_2,
            'activitySectionDescription2' => $this->section_description_2,
            'activitySectionType2' => $this->section_type_2,
            'activitySectionTitle3' => $this->section_title_3,
            'activitySectionDescription3' => $this->section_description_3,
            'activitySectionType3' => $this->section_type_3,
            'activityTags' => TagResource::collection($this->whenLoaded('tags')),
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('activities.show', $this->id)
                ],
                [
                    'rel' => 'activities.tags',
                    'href' => route('activities.tags.index', $this->id)
                ],
                [
                    'rel' => 'activities.mains',
                    'href' => route('activities.mains.index', $this->id)
                ],
                [
                    'rel' => 'activities.benefits',
                    'href' => route('activities.benefits.index', $this->id)
                ],
                [
                    'rel' => 'activities.offers',
                    'href' => route('activities.offers.index', $this->id)
                ],
                [
                    'rel' => 'activities.sections',
                    'href' => route('activities.sections.index', $this->id)
                ],
                [
                    'rel' => 'activities.blogs',
                    'href' => route('activities.blogs.index', $this->id)
                ],
                [
                    'rel' => 'activities.categories',
                    'href' => route('activities.categories.index', $this->id)
                ],
            ]
        ];
    }
}
