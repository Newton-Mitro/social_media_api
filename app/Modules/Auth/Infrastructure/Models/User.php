<?php

namespace App\Modules\Auth\Infrastructure\Models;

use App\Modules\Follow\Infrastructure\Models\Follow;
use App\Modules\Post\Infrastructure\Models\Comment;
use App\Modules\Post\Infrastructure\Models\Post;
use App\Modules\Post\Infrastructure\Models\Reaction;
use App\Modules\Post\Infrastructure\Models\Share;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'id',
        'name',
        'display_name',
        'email',
        'password',
        'email_verified_at',
        'last_logged_in',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'id' => 'string',
        'email_verified_at' => 'datetime',
        'last_logged_in' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function postReactions()
    {
        return $this->hasManyThrough(Reaction::class, Post::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
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

    public function userFollowers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id');
    }

    public function userFollowing()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id');
    }

    // Relationship for accepted friends
    public function friends(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
            ->wherePivotNotNull('accepted_at'); // Only accepted friends
    }

    // Relationship for sent friend requests (pending status where `accepted_at` is null)
    public function sentFriendRequests(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
            ->wherePivotNull('accepted_at'); // Only pending requests
    }

    // Relationship for received friend requests (pending status)
    public function pendingFriendRequests(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id')
            ->wherePivotNull('accepted_at'); // Only pending requests
    }
}
