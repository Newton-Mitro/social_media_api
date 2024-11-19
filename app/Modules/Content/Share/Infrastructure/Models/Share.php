<?php

namespace App\Modules\Content\Share\Infrastructure\Models;

use App\Modules\Auth\Infrastructure\Models\User;
use App\Modules\Content\Post\Infrastructure\Models\Post;
use Database\Factories\ShareFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id',
        'post_id',
        'user_id',
    ];

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
