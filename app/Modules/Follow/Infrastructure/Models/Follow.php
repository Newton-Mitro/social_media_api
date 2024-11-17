<?php

namespace App\Modules\Follow\Infrastructure\Models;

use App\Modules\Auth\Infrastructure\Models\User;
use FollowFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Follow extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'follower_id',
        'following_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($follow) {
            $follow->id = (string) Str::uuid(); // Generate UUID when creating a new post
        });
    }

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
