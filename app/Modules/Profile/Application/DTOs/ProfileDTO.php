<?php

namespace App\Modules\Profile\Application\DTOs;

use App\Modules\Profile\Domain\Entities\ProfileEntity;

class ProfileDTO
{
    public function __construct(
        public ?string $id,
        public string $user_id,
        public ?string $sex,
        public ?string $dbo,
        public ?string $mobile_number,
        public ?string $profile_picture,
        public ?string $cover_photo,
        public ?string $bio,
        public string $created_at,
        public string $updated_at
    ) {}
}
