<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Userallnamev2Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message1' => 'This message is from v2 API',
            'message2' => 'Rate limiting set to 3 requests per minute',
            'name' => $this->name
        ];
    }
}
