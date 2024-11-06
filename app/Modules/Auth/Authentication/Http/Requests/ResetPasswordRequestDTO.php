<?php

namespace App\Modules\Auth\Authentication\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequestDTO extends FormRequest
{
    public string $email;
    public string $password;
    public string $token;

    public function __construct(ResetPasswordRequest $request)
    {
        $this->email = $request->input('email');
        $this->password = $request->input('password');
        $this->token = $request->input('token');
    }
}
