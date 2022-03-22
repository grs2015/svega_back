<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'userFirstName' => $this->first_name,
            'userLastName' => $this->last_name,
            'userRole' => $this->role,
            'userEmail' => $this->email,
            'verifiedAt' => $this->email_verified_at,
        ];
    }
}
