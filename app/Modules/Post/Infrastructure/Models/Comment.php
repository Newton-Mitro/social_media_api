<?php

namespace App\Modules\Post\Infrastructure\Models;

use App\Modules\Auth\Infrastructure\Models\User;
use App\Modules\Post\Infrastructure\Models\Like;
use Database\Factories\CommentFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Comment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($comment) {
            $comment->id = (string) Str::uuid(); // Generate UUID when creating a new post
        });
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function reactions(): MorphMany
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory()
    {
        return new CommentFactory();
    }
}
