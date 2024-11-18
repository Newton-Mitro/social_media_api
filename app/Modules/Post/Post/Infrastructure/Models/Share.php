<?php

namespace App\Modules\Post\Infrastructure\Models;

use Illuminate\Support\Str;
use Database\Factories\ShareFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Auth\Infrastructure\Models\User;
use App\Modules\Post\Infrastructure\Models\Post;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
