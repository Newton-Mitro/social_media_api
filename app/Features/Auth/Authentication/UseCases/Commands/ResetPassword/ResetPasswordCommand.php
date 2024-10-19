<?php

namespace App\Features\Auth\Authentication\UseCases\Commands\ResetPassword;

use App\Core\Bus\Command;

class ResetPasswordCommand extends Command
{
    public function __construct(
        private readonly string $email,
        private readonly string $password,
        private readonly string $token
    ) {
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the value of token
     */
    public function getToken()
    {
        return $this->token;
    }
}
