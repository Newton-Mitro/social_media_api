<?php

namespace App\Modules\Auth\Authentication\Requests;

class UserRegistrationRequestDTO
{
    public string $name;

    public string $email;

    public string $password;

    public function __construct(UserRegistrationRequest $request)
    {
        $this->name = $request->input('name');
        $this->email = $request->input('email');
        $this->password = $request->input('password');
    }
}
