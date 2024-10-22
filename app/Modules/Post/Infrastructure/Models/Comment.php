<?php

namespace App\Modules\Post\Infrastructure\Models;

use App\Modules\Auth\User\Models\User;
use Database\Factories\CommentFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Post\Infrastructure\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'user_id', 'comment_text', 'timestamp'];

    public function post()
    {
        return $this->belongsTo(Post::class);
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
