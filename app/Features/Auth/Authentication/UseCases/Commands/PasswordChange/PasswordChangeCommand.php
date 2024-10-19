<?php

namespace App\Features\Auth\Authentication\UseCases\Commands\PasswordChange;

use App\Core\Bus\Command;

class PasswordChangeCommand extends Command
{
    public function __construct(
        private readonly string $email,
        private readonly string $password,
        private readonly string $old_password,
    ) {}

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getOldPassword(): string
    {
        return $this->old_password;
    }
}
