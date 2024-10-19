<?php

namespace App\Features\Auth\Authentication\UseCases\Commands\Register;

use App\Core\Bus\Command;

class RegisterUserCommand extends Command
{
    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $password,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
