<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'contactName' => $this->name,
            'contactEmail' => $this->email,
            'contactRequest' => $this->request,
            'contactStatus' => $this->status,
            'contactManager' => $this->manager,
            'contactDate' => $this->date,
            'contactConfirmation' => $this->confirm
        ];
    }
}
