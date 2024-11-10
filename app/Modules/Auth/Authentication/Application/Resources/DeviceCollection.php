<?php

namespace App\Modules\Auth\Authentication\Application\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DeviceCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data' => $this->collection,
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
