<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserdatawrappingResourceCollection extends ResourceCollection
{
    public static $wrap = 'users';

    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
