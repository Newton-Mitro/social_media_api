<?php

namespace App\Features\Auth\User\UseCases\Commands\UpdateUser;

use App\Core\Bus\Command;
use DateTimeImmutable;

class UpdateProfilePictureCommand extends Command
{
    public function __construct(
        private readonly int $userId,
        private readonly string $profilePicture
    ) {}

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProfilePicture(): string
    {
        return $this->profilePicture;
    }
}
