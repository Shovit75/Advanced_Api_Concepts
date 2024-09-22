<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserdatawrappingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'message' => 'This message is from v1 API',
            'name' => $this->name,
            'email' => $this->email,
            'posts' => PostResource::collection($this->posts), 
        ];
    }
}
