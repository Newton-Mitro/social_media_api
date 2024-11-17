<?php

namespace App\Modules\Post\Infrastructure\Models;

use Illuminate\Support\Str;
use Database\Factories\ShareFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Auth\Infrastructure\Models\User;
use App\Modules\Post\Infrastructure\Models\Post;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Share extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'post_id',
        'user_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($share) {
            $share->id = (string) Str::uuid(); // Generate UUID when creating a new post
        });
    }

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
