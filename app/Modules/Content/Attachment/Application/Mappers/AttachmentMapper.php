<?php

namespace App\Modules\Content\Attachment\Application\Mappers;

use App\Modules\Content\Attachment\Application\DTOs\AttachmentDTO;
use App\Modules\Content\Attachment\Domain\Entities\AttachmentEntity;
use DateTimeImmutable;
use Illuminate\Support\Collection;

class AttachmentMapper
{
    public static function toDTO(AttachmentEntity $entity): AttachmentDTO
    {
        $attachmentDTO = new AttachmentDTO();
        $attachmentDTO->id = $entity->getId();
        $attachmentDTO->post_id = $entity->getPostId();
        $attachmentDTO->mime_type = $entity->getMimeType();
        $attachmentDTO->file_url = $entity->getFileURL();
        $attachmentDTO->file_path = $entity->getFilePath();
        $attachmentDTO->file_name = $entity->getFileName();
        $attachmentDTO->thumbnail_url = $entity->getThumbnailURL();
        $attachmentDTO->title = $entity->getTitle();
        $attachmentDTO->description = $entity->getDescription();
        $attachmentDTO->duration = $entity->getDuration();
        $attachmentDTO->comment_count = $entity->getCommentCount();
        $attachmentDTO->reaction_count = $entity->getReactionCount();
        $attachmentDTO->view_count = $entity->getViewCount();
        $attachmentDTO->share_count = $entity->getShareCount();
        $attachmentDTO->created_at = $entity->getCreatedAt()->format(DateTimeImmutable::ATOM);
        $attachmentDTO->updated_at = $entity->getUpdatedAt()->format(DateTimeImmutable::ATOM);

        return $attachmentDTO;
    }

    public static function toDTOCollection(Collection $entities): Collection
    {
        return $entities->map([self::class, 'toDTO']);
    }
}
