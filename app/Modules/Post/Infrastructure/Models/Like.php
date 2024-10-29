<?php

namespace App\Modules\Post\Infrastructure\Models;

use App\Modules\Auth\User\Models\User;
use Database\Factories\LikeFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

class Like extends Model
{
    use HasFactory, HasUuids;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($like) {
            $like->id = (string) Str::uuid();
        });
    }

    protected $fillable = ['user_id'];

    public function likable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory()
    {
        return new LikeFactory();
    }
}
