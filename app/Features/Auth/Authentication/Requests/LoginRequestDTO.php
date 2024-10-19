<?php

namespace App\Features\Auth\Authentication\Requests;

class LoginRequestDTO
{
    public string $email;

    public string $password;

    public function __construct(LoginRequest $request)
    {
        $this->email = $request->input('email');
        $this->password = $request->input('password');
    }
}
