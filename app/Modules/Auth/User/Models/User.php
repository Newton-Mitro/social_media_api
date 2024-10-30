<?php

namespace App\Modules\Auth\User\Models;

use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Database\Factories\UserFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Modules\Post\Infrastructure\Models\Like;
use App\Modules\Post\Infrastructure\Models\Post;
use App\Modules\Post\Infrastructure\Models\Share;
use App\Modules\Post\Infrastructure\Models\Comment;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Modules\Follow\Infrastructure\Models\Follow;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasUuids;

    protected $fillable = [];

    protected $hidden = [
        'password',
        'otp',
        'otp_expires_at',
        'otp_verified',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->id = (string) Str::uuid(); // Generate UUID when creating a new user
        });
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function shares()
    {
        return $this->hasMany(Share::class);
    }

    protected static function newFactory()
    {
        return new UserFactory;
    }

    public function followers(): HasMany
    {
        return $this->hasMany(Follow::class, 'following_id');
    }

    public function following(): HasMany
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }
}
