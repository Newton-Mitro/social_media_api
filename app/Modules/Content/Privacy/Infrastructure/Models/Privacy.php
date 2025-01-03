<?php

namespace App\Modules\Content\Privacy\Infrastructure\Models;

use App\Modules\Content\Post\Infrastructure\Models\Post;
use Database\Factories\PrivacyFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privacy extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['id', 'privacy_name',];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    protected static function newFactory()
    {
        return new PrivacyFactory();
    }
}
