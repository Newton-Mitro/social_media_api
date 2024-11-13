<?php

namespace App\Modules\Post\Infrastructure\Models;

use Database\Factories\ShareFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Post\Infrastructure\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Auth\Infrastructure\Models\User;

class Share extends Model
{
    use HasFactory;

    protected $fillable = [];

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
        return new ShareFactory();
    }
}
