<?php

namespace App\Modules\Friend\Infrastructure\Models;

use App\Modules\Auth\Infrastructure\Models\User;
use FriendRequestFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FriendRequest extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'status',
    ];

    protected $casts = [
        'status' => 'string', // Assuming 'status' is an enum or string type
    ];

    /**
     * Get the user who sent the friend request.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the user who received the friend request.
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    protected static function newFactory()
    {
        return new FriendRequestFactory();
    }
}
