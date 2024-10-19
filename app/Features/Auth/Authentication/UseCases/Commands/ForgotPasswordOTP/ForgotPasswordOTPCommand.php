<?php

namespace App\Features\Auth\Authentication\UseCases\Commands\ForgotPasswordOTP;

use App\Core\Bus\Command;

class ForgotPasswordOTPCommand extends Command
{
    public function __construct(
        private readonly string  $email
    )
    {
    }

        /**
         * Get the value of email
         */ 
        public function getEmail()
        {
                return $this->email;
        }
}
