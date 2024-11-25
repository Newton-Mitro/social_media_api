<?php

namespace App\Modules\Content\View\Infrastructure\Models;

use App\Modules\Auth\Infrastructure\Models\User;
use App\Modules\Content\Attachment\Infrastructure\Models\Attachment;
use App\Modules\Content\Post\Infrastructure\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'attachment_id', 'shared_by', 'shared_to', 'message'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }

    public function sharedBy()
    {
        return $this->belongsTo(User::class, 'shared_by');
    }
}
