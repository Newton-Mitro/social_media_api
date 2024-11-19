<?php

namespace App\Modules\Content\Comment\Infrastructure\Models;

use Database\Factories\CommentFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Auth\Infrastructure\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Content\Reaction\Infrastructure\Models\Reaction;

class Comment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'commentable_id',
        'commentable_type',
        'user_id',
        'comment_text',
        'parent_id',
    ];

    public function reactions(): MorphMany
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')->orderBy('created_at');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    protected static function newFactory()
    {
        return new CommentFactory();
    }
}
