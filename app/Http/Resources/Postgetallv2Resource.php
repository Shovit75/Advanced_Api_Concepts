<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Postgetallv2Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'This message is from v2 API',
            'message2' => 'Rate limiting set to 2 requests per minute',
            'mulitpleimage' => $this->multipleimage,
        ];
    }
}
