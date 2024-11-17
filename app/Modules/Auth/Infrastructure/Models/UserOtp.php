<?php

namespace App\Modules\Auth\Infrastructure\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserOtp extends Model
{
    use HasFactory, HasUuids;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($userOtp) {
            $userOtp->id = (string) Str::uuid(); // Generate UUID when creating a new post
        });
    }

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
