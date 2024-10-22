<?php

namespace App\Modules\Post\Infrastructure\Models;

use Database\Factories\LikeFactory;
use App\Modules\Auth\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Post\Infrastructure\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'user_id'];

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
        return new LikeFactory();
    }
}
