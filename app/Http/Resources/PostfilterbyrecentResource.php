<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PostfilterbyrecentResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'mulitpleimage' => $this->multipleimage,
            'post_created_at' => Carbon::parse($this->created_at)->format('d-m-Y h:i:s A'),
        ];
    }
}
