<?php

namespace App\Modules\Post\Infrastructure\Models;

use Database\Factories\PostFactory;
use App\Modules\Auth\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Post\Infrastructure\Models\Like;
use App\Modules\Post\Infrastructure\Models\Share;
use App\Modules\Post\Infrastructure\Models\Comment;
use App\Modules\Post\Infrastructure\Models\Privacy;
use App\Modules\Post\Infrastructure\Models\Attachment;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'likes', 'shares', 'location', 'privacy_id', 'user_id'];

    public function privacy()
    {
        return $this->belongsTo(Privacy::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likable');
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
