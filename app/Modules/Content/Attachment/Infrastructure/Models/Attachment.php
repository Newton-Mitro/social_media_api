<?php

namespace App\Modules\Content\Attachment\Infrastructure\Models;

use App\Modules\Content\Comment\Infrastructure\Models\Comment;
use App\Modules\Content\Post\Infrastructure\Models\Post;
use App\Modules\Content\Reaction\Infrastructure\Models\Reaction;
use Database\Factories\AttachmentFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'post_id',
        'mime_type',
        'file_url',
        'file_path',
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
