<?php

namespace App\Modules\Post\Infrastructure\Models;

use App\Modules\Post\Infrastructure\Models\Post;
use Database\Factories\PrivacyFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Privacy extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = ['privacy_name',];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($privacy) {
            $privacy->id = (string) Str::uuid(); // Generate UUID when creating a new post
        });
    }


    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    protected static function newFactory()
    {
        return new PrivacyFactory();
    }
}
