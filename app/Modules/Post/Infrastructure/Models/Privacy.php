<?php

namespace App\Modules\Post\Infrastructure\Models;

use Database\Factories\PrivacyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privacy extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return new PrivacyFactory();
    }
}
