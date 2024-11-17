<?php

namespace App\Core\Enums;

enum OtpTypes: string
{
    case USER_REGISTERED = 'User Registered';
    case FORGOT_PASSWORD = 'Forgot Password';
}
