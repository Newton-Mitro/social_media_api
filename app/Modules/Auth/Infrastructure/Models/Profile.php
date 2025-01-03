<?php

namespace App\Modules\Auth\Infrastructure\Models;

use App\Modules\Auth\Infrastructure\Models\User;
use Database\Factories\ProfileFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Profile extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, HasUuids;

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
        'id' => 'string'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory()
    {
        return new ProfileFactory();
    }
}
