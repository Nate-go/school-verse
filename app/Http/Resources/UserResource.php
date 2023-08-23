<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'->$this->id,
            'role'->$this->role,
            'status'->$this->status,
            'email'->$this->email,
            'username'->$this->profile->username,
            'image_url'->$this->profile->image_url,
        ];
    }
}
