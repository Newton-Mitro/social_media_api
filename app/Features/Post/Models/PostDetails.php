<?php

namespace App\Features\Post\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostDetails extends Model
{
    use HasFactory;

    protected $table = 'user_contents_posting_details';

    protected $primaryKey = 'user_content_id';

    protected $fillable = [
         'user_content_id'
        ,'content_url'
        ,'content_name'
        ,'content_create_date'
        ,'modified_at'
        ,'user_contents_post_id'
        ,'like_count'
        ,'view_count'
        ,'share_count'
        ,'content_type'
    ];

    public function post(): BelongsTo
    {
        return $this->hasOne(Post::class, 'user_contents_post_id', 'user_content_id');
    }

}
