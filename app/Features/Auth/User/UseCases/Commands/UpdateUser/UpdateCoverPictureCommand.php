<?php

namespace App\Features\Auth\User\UseCases\Commands\UpdateUser;

use App\Core\Bus\Command;
use DateTimeImmutable;

class UpdateCoverPictureCommand extends Command
{
    public function __construct(
        private readonly int $userId,
        private readonly string $coverPhoto
    ) {}

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCoverPhoto(): string
    {
        return $this->coverPhoto;
    }
}
