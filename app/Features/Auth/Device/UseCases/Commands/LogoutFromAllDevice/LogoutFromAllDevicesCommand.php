<?php

namespace App\Features\Auth\Device\UseCases\Commands\LogoutFromAllDevice;

use App\Core\Bus\Command;

class LogoutFromAllDevicesCommand extends Command
{
    public function __construct(
        private readonly int $user_id,
    ) {}

    public function getUserId(): int
    {
        return $this->user_id;
    }
}
