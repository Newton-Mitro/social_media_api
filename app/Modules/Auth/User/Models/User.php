<?php

namespace App\Features\Auth\User\Models;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $table = 'aut_user_registration';

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'name',
        'user_name',
        'email',
        'password',
        'profile_picture',
        'cover_photo',
        'email_verified_at',
        'otp',
        'otp_expired_at',
        'otp_verified',
        'last_logged_in',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password',
        'otp',
        'otp_expires_at',
        'otp_verified',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function newFactory()
    {
        return new UserFactory;
    }
}
