<?php

namespace App\Modules\Auth\OTP\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOtp extends Model
{
    use HasFactory;

    protected $fillable = [
        'otp',
        'user_id',
        'expires_at',
        'is_verified',
        'token',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    // protected static function newFactory()
    // {
    //     return new UserOTPFactory;
    // }
}
