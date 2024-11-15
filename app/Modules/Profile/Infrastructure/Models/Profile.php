<?php

namespace App\Modules\Profile\Infrastructure\Models;

use App\Modules\Auth\Infrastructure\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class Profile extends Authenticatable implements MustVerifyEmail
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'id',
        'user_id',
        'sex',
        'dbo',
        'mobile_number',
        'profile_picture',
        'cover_photo',
        'bio',
    ];

    protected $casts = [
        'id' => 'string',
        'dbo' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($profile) {
            $profile->id = (string) Str::uuid();
        });
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
