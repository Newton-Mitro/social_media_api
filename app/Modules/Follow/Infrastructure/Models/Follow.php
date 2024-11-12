<?php

namespace App\Modules\Follow\Infrastructure\Models;

use App\Modules\Auth\Authentication\Infrastructure\Models\User;
use FollowFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Follow extends Model
{
    protected $fillable = [
        'follower_id',
        'following_id',
    ];

    /**
     * Get the user who is following.
     */
    public function follower(): BelongsTo
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    /**
     * Get the user being followed.
     */
    public function following(): BelongsTo
    {
        return $this->belongsTo(User::class, 'following_id');
    }

    protected static function newFactory()
    {
        return new FollowFactory();
    }
}
