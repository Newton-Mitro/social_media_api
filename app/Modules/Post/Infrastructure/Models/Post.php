<?php

namespace App\Modules\Post\Infrastructure\Models;

use App\Modules\Auth\Authentication\Infrastructure\Models\User;
use App\Modules\Post\Infrastructure\Models\Attachment;
use App\Modules\Post\Infrastructure\Models\Comment;
use App\Modules\Post\Infrastructure\Models\Like;
use App\Modules\Post\Infrastructure\Models\Privacy;
use App\Modules\Post\Infrastructure\Models\Share;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['body', 'likes', 'shares', 'location', 'privacy_id', 'user_id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->id = (string) Str::uuid(); // Generate UUID when creating a new post
        });
    }

    public function privacy()
    {
        return $this->belongsTo(Privacy::class);
    }

    public function user()
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

    public function likes(): MorphMany
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
