<?php

namespace App\Domains\Auth\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'department' => $this->whenLoaded('department'),
            'roles'      => $this->roles->pluck('name'),
            'is_active'  => $this->is_active,
        ];
    }
}
