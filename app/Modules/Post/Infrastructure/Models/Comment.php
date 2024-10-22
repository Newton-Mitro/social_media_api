<?php

namespace App\Modules\Post\Infrastructure\Models;

use Database\Factories\CommentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return new CommentFactory();
    }
}
