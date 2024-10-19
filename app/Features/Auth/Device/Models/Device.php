<?php

namespace App\Features\Auth\Device\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $table = 'device_info';

    protected $primaryKey = 'device_id';

    protected $fillable = ['user_id', 'device_token', 'device_name', 'device_ip', 'device_identifier'];
}
