<?php

namespace App\Modules\Post\Infrastructure\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\AttachmentFactory;
use App\Modules\Post\Infrastructure\Models\Like;
use App\Modules\Post\Infrastructure\Models\Post;
use App\Modules\Post\Infrastructure\Models\Comment;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attachment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'post_id',
        'type',
        'url',
        'path',
        'file_name',
        'thumbnail_url',
        'description',
        'duration',
        'likes',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($attachment) {
            $attachment->id = (string) Str::uuid(); // Generate UUID when creating a new post
        });
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
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
