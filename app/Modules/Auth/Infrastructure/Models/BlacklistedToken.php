<?php

namespace App\Modules\Auth\Infrastructure\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlacklistedToken extends Model
{
    use HasFactory, HasUuids;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blacklistedToken) {
            $blacklistedToken->id = (string) Str::uuid(); // Generate UUID when creating a new post
        });
    }

    protected $fillable = ['token'];
}
