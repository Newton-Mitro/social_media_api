<?php

namespace App\Modules\Post\Infrastructure\Models;

use Database\Factories\LikeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return new LikeFactory();
    }
}
