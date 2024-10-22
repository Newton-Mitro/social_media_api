<?php

namespace App\Modules\Post\Infrastructure\Models;

use Database\Factories\AttachmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return new AttachmentFactory();
    }
}
