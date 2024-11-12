<?php

namespace App\Modules\Auth\Authentication\Infrastructure\Models;

use App\Modules\Auth\Authentication\Infrastructure\Models\User;
use FriendFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Friend extends Model
{
    protected $fillable = [
        'user_id',
        'friend_id',
        'accepted_at',
    ];

    protected $dates = ['accepted_at'];

    /**
     * Get the user who owns this friendship.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the friend user in this friendship.
     */
    public function friend(): BelongsTo
    {
        return $this->belongsTo(User::class, 'friend_id');
    }

    protected static function newFactory()
    {
        return new FriendFactory();
    }
}
