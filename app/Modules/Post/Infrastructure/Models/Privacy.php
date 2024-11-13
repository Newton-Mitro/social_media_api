<?php

namespace App\Modules\Post\Infrastructure\Models;

use Database\Factories\PrivacyFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Post\Infrastructure\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Privacy extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    protected static function newFactory()
    {
        return new PrivacyFactory();
    }
}
