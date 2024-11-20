<?php

namespace App\Modules\Content\Attachment\Application\DTOs;

use DateTimeImmutable;


class AttachmentDTO
{
    public string $id;
    public string $post_id;
    public string $file_url;
    public string $thumbnail_url;
    public string $mime_type;
    public string $file_name;
    public string $file_path;
    public string $title;
    public string $description;
    public string $duration;
    public int $reaction_count;
    public int $view_count;
    public int $share_count;
    public int $comment_count;
    public DateTimeImmutable $created_at;
    public DateTimeImmutable $updated_at;
}
