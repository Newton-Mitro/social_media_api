<?php

namespace App\Modules\Post\Infrastructure\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\AttachmentFactory;
use App\Modules\Post\Infrastructure\Models\Post;
use App\Modules\Post\Infrastructure\Models\Comment;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'post_id',
        'type',
        'url',
        'path',
        'file_name',
        'thumbnail_url',
        'title',
        'description',
        'duration',
        'comment_count',
        'reaction_count',
        'view_count',
        'share_count',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function reactions()
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    protected static function newFactory()
    {
        return new AttachmentFactory();
    }
}
