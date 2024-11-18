<?php

namespace App\Modules\Post\Domain\Interfaces;

use App\Modules\Post\Domain\Entities\AttachmentEntity;
use App\Modules\Post\Domain\Entities\PostAggregate;
use Illuminate\Support\Collection;

interface AttachmentRepositoryInterface
{
    public function saveAttachments(PostAggregate $post, Collection $attachments): void;
    public function removeComment(PostAggregate $post, AttachmentEntity $attachment): void;
    public function updateComment(PostAggregate $post, AttachmentEntity $attachment): void;
    public function saveAttachment(PostAggregate $post, AttachmentEntity $attachment): void;
}
