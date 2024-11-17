<?php

namespace App\Modules\Friend\Infrastructure\Models;

use App\Modules\Auth\Infrastructure\Models\User;
use FriendRequestFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class FriendRequest extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'status',
    ];

    protected $casts = [
        'status' => 'string', // Assuming 'status' is an enum or string type
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($friendRequest) {
            $friendRequest->id = (string) Str::uuid(); // Generate UUID when creating a new post
        });
    }

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
