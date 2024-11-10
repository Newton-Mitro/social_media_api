<?php

namespace App\Modules\Auth\Authentication\Application\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'user_id' => $this->user_id,
            'device_token' => $this->device_token,
            'device_name' => $this->device_name,
            'device_ip' => $this->device_ip,
        ];
    }
}
