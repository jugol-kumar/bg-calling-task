<?php

namespace App\Http\Resources\Resource\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // make json response for user resource
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => Storage::url($this->image),
            'createdAt' => $this->created_at?->format('YYYY-MM-DD'),
            'roles' => $this->roles,
        ];
    }
}
