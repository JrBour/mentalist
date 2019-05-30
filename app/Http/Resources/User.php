<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'username' => $this->username,
            'name' => $this->name,
            'admin' => $this->admin,
            'email' => $this->email,
            'email_hashed' => $this->email_hashed,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
