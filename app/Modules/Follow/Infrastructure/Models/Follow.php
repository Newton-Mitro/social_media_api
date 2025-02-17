<?php

namespace App\Modules\Follow\Infrastructure\Models;

use App\Modules\Auth\Infrastructure\Models\User;
use FollowFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Follow extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'follower_id',
        'following_id',
    ];

    public function follower(): BelongsTo
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    public function following(): BelongsTo
    {
        return $this->belongsTo(User::class, 'following_id');
    }

    protected static function newFactory()
    {
        return new FollowFactory();
    }
}
