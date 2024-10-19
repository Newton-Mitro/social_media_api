<?php

namespace App\Modules\Auth\Authentication\Requests;

class PasswordChangeRequestDTO
{
    // public string $email;

    public string $password;

    public string $old_password;

    public function __construct(PasswordChangeRequest $request)
    {
        // $this->email = $request->input('email');
        $this->password = $request->input('password');
        $this->old_password = $request->input('old_password');
    }
}
