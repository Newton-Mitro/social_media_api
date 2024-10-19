<?php
namespace App\Features\Auth\Privacy\Model;
use Illuminate\Database\Eloquent\Model;

class Privacy extends Model
{
    protected $table = 'post_privacy_settings';

    protected $primaryKey = 'privacy_setting_id';
    public $timestamps = false;

    protected $fillable = [
        'privacy_setting_id',
        'privacy_setting_name',
        'remarks',
        'created_date'
    ];
}