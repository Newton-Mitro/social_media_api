<?php

namespace App\Modules\Post\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Post\Models\PostDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $table = 'user_contents_posting';

    protected $primaryKey = 'user_contents_post_id';
    public $timestamps = false;

    protected $fillable = [
        'user_contents_post_id',
        'user_id,content_type_id',
        'content_header_text',
        'content_post_date',
        'content_expire_date',
        'like_count',
        'share_count',
        'followers_subscribers_count',
        'is_active',
        'created_at',
        'modified_at',
        'privacy_setting_id'
    ];
    public function postdetails()
    {
        return $this->hasMany(PostDetails::class, 'user_contents_post_id', 'user_contents_post_id');
    }
}
