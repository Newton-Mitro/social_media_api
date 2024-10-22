<?php

namespace App\Modules\Post\Infrastructure\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return new PostFactory();
    }
}
