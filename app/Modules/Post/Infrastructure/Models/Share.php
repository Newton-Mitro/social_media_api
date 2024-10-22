<?php

namespace App\Modules\Post\Infrastructure\Models;

use Database\Factories\ShareFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return new ShareFactory();
    }
}
