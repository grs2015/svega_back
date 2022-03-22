<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MainResource extends JsonResource
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
            'mainTitle' => $this->main_title,
            'mainImage' => $this->main_image,
            'mainParallaxImages' => $this->parallax_images,
            'mainCompanyName' => $this->company_name,
            'mainCompanyData' => $this->company_data,
            'mainAddress' => $this->address,
            'mainPhone' => $this->phone,
            'mainEmail' => $this->email,
            'mainWebsite' => $this->website,
            'mainSloganTitle' => $this->slogan_text,
            'mainBlogCount' => $this->blogs_count,
            'mainSloganDescription' => $this->slogan_description,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('mains.show', $this->id)
                ],
                [
                    'rel' => 'mains.offers',
                    'href' => route('mains.offers.index', $this->id)
                ],
                [
                    'rel' => 'mains.benefits',
                    'href' => route('mains.benefits.index', $this->id)
                ],
                [
                    'rel' => 'mains.activities',
                    'href' => route('mains.activities.index', $this->id)
                ],
                [
                    'rel' => 'mains.sections',
                    'href' => route('mains.sections.index', $this->id)
                ],
                [
                    'rel' => 'mains.blogs',
                    'href' => route('mains.blogs.index', $this->id)
                ],
                [
                    'rel' => 'mains.tags',
                    'href' => route('mains.tags.index', $this->id)
                ],
                [
                    'rel' => 'mains.categories',
                    'href' => route('mains.categories.index', $this->id)
                ],
            ]
        ];
    }
}
