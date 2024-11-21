<?php

namespace App\Modules\Content\Post\Infrastructure\Models;

use App\Modules\Auth\Infrastructure\Models\User;
use App\Modules\Content\Attachment\Infrastructure\Models\Attachment;
use App\Modules\Content\Comment\Infrastructure\Models\Comment;
use App\Modules\Content\Privacy\Infrastructure\Models\Privacy;
use App\Modules\Content\Reaction\Infrastructure\Models\Reaction;
use App\Modules\Content\Share\Infrastructure\Models\Share;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'post_text',
        'reaction_count',
        'share_count',
        'view_count',
        'comment_count',
        'location',
        'privacy_id',
        'user_id',
    ];

    public function privacy()
    {
        return $this->belongsTo(Privacy::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function reactions(): MorphMany
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }

    public function shares()
    {
        return $this->hasMany(Share::class);
    }

    protected static function newFactory()
    {
        return new PostFactory();
    }
}
