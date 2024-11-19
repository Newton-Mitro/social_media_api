<?php

namespace App\Modules\Content\Post\Domain\Repositories;

use Illuminate\Support\Collection;
use App\Modules\Content\Post\Domain\Aggregates\PostAggregate;
use App\Modules\Content\Post\Domain\Entities\AttachmentEntity;

interface AttachmentRepositoryInterface
{
    public function saveAttachments(PostAggregate $post, Collection $attachments): void;
    public function removeComment(PostAggregate $post, AttachmentEntity $attachment): void;
    public function updateComment(PostAggregate $post, AttachmentEntity $attachment): void;
    public function saveAttachment(PostAggregate $post, AttachmentEntity $attachment): void;
}
