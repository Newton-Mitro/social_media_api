<?php

namespace App\Modules\Friend\Infrastructure\Models;

use App\Modules\Auth\Infrastructure\Models\User;
use FriendRequestFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FriendRequest extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'sender_id',
        'receiver_id',
        'status',
    ];

    protected $casts = [
        'status' => 'string', // Assuming 'status' is an enum or string type
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    protected static function newFactory()
    {
        return new FriendRequestFactory();
    }
}
