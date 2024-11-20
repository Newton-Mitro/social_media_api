<?php

namespace App\Modules\Content\Attachment\Infrastructure\Mappers;

use App\Modules\Content\Attachment\Domain\Entities\AttachmentEntity;
use App\Modules\Content\Attachment\Infrastructure\Models\Attachment;

class AttachmentMapper
{
    public static function toEntity(Attachment $model): AttachmentEntity
    {
        $attachment = new AttachmentEntity(
            id: $model->id,
            postId: $model->post_id,
            mimeType: $model->mime_type,
            fileURL: $model->file_url,
            filePath: $model->file_path,
            fileName: $model->file_name,
            thumbnailUrl: $model->thumbnail_url,
            title: $model->title,
            description: $model->description,
            duration: $model->duration,
            commentCount: $model->commentCount,
            reactionCount: $model->reactionCount,
            viewCount: $model->viewCount,
            shareCount: $model->shareCount,
            createdAt: new \DateTimeImmutable($model->updated_at),
            updatedAt: new \DateTimeImmutable($model->updated_at)
        );
        return $attachment;
    }

    public static function toEntityCollection(array $models): array
    {
        return array_map([self::class, 'toEntity'], $models);
    }

    public static function toModel(AttachmentEntity $entity): Attachment
    {
        $model = new Attachment();
        $model->id = $entity->getId();
        $model->post_id = $entity->getPostId();
        $model->mime_type = $entity->getMimeType();
        $model->file_url = $entity->getFileURL();
        $model->file_path = $entity->getFilePath();
        $model->file_name = $entity->getFileName();
        $model->thumbnail_url = $entity->getThumbnailURL();
        $model->title = $entity->getTitle();
        $model->description = $entity->getDescription();
        $model->duration = $entity->getDuration();
        $model->comment_count = $entity->getCommentCount();
        $model->reaction_count = $entity->getReactionCount();
        $model->view_count = $entity->getViewCount();
        $model->share_count = $entity->getShareCount();
        $model->created_at = $entity->getCreatedAt();
        $model->updated_at = $entity->getUpdatedAt();

        return $model;
    }
}
