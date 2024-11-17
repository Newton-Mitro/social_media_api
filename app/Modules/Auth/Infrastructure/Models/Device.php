<?php

namespace App\Modules\Auth\Infrastructure\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Device extends Model
{
    use HasFactory, HasUuids;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($device) {
            $device->id = (string) Str::uuid(); // Generate UUID when creating a new post
        });
    }


    protected $fillable = ['user_id', 'device_token', 'device_name', 'device_ip', 'device_identifier'];
}
