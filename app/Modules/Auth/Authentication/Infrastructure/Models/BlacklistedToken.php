<?php

namespace App\Modules\Auth\Authentication\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlacklistedToken extends Model
{
    use HasFactory;

    protected $fillable = ['token'];
}
