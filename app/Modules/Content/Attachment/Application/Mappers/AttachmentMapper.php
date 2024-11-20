<?php

namespace App\Modules\Content\Attachment\Application\Mappers;

use App\Modules\Content\Attachment\Application\DTOs\AttachmentDTO;
use App\Modules\Content\Attachment\Domain\Entities\AttachmentEntity;
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
        $attachmentDTO->created_at = $entity->getCreatedAt()->format('Y-m-d H:i:s');
        $attachmentDTO->updated_at = $entity->getUpdatedAt()->format('Y-m-d H:i:s');

        return $attachmentDTO;
    }

    public static function toDTOCollection(Collection $entities): Collection
    {
        return $entities->map([self::class, 'toDTO']);
    }

    public static function toEntity(array $payload): AttachmentEntity
    {
        $attachment = new AttachmentEntity(
            id: $payload['id'] ?? null,
            postId: $payload['post_id'] ?? null,
            mimeType: $payload['mime_type'] ?? null,
            fileURL: $payload['file_url'] ?? null,
            filePath: $payload['file_path'] ?? null,
            fileName: $payload['file_name'] ?? null,
            thumbnailUrl: $payload['thumbnail_url'] ?? null,
            title: $payload['title'] ?? null,
            description: $payload['description'] ?? null,
            duration: $payload['duration'] ?? null,
            commentCount: $payload['comment_count'] ?? 0,
            reactionCount: $payload['reaction_count'] ?? 0,
            viewCount: $payload['view_count'] ?? 0,
            shareCount: $payload['share_count'] ?? 0,
            createdAt: isset($payload['created_at'])
                ? new \DateTimeImmutable($payload['created_at'])
                : new \DateTimeImmutable(),
            updatedAt: isset($payload['updated_at'])
                ? new \DateTimeImmutable($payload['updated_at'])
                : new \DateTimeImmutable()
        );
        return $attachment;
    }
}
