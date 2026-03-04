<?php

namespace App\Domains\Staff\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
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
