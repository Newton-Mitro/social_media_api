<?php

namespace App\Modules\Content\Attachment\Infrastructure\Repositories;

use App\Modules\Content\Attachment\Domain\Entities\AttachmentEntity;
use App\Modules\Content\Attachment\Domain\Repositories\AttachmentRepositoryInterface;
use App\Modules\Content\Attachment\Infrastructure\Mappers\AttachmentMapper;
use App\Modules\Content\Attachment\Infrastructure\Models\Attachment;
use Illuminate\Support\Collection;

class AttachmentRepository implements AttachmentRepositoryInterface
{
    public function getAll(): Collection
    {
        $attachments = Attachment::all();

        return AttachmentMapper::toEntityCollection($attachments);
    }

    public function findById(string $id): ?AttachmentEntity
    {
        $model = Attachment::find($id);
        return $model ? AttachmentMapper::toEntity($model) : null;
    }

    public function save(AttachmentEntity $attachment): AttachmentEntity
    {
        $model = Attachment::updateOrCreate(
            ['id' => $attachment->getId()],
            [
                'post_id' => $attachment->getPostId(),
                'type' => $attachment->getMimeType(),
                'url' => $attachment->getFileURL(),
                'path' => $attachment->getFilePath(),
                'file_name' => $attachment->getFileName(),
                'thumbnail_url' => $attachment->getThumbnailUrl(),
                'title' => $attachment->getTitle(),
                'description' => $attachment->getDescription(),
                'duration' => $attachment->getDuration(),
                'comment_count' => $attachment->getCommentCount(),
                'reaction_count' => $attachment->getReactionCount(),
                'view_count' => $attachment->getViewCount(),
                'share_count' => $attachment->getShareCount(),
                'created_at' => $attachment->getCreatedAt(),
                'updated_at' => $attachment->getUpdatedAt(),
            ]
        );

        return $this->toDomain($model);
    }

    public function update(string $id, array $data): bool
    {
        $model = Attachment::find($id);
        if ($model) {
            $model->update($data); // Only updates fields in the $data array
            return true;
        }
        return false;
    }

    public function delete(string $id): bool
    {
        $model = Attachment::find($id);
        if ($model) {
            return $model->delete();
        }
        return false;
    }

    private function toDomain(AttachmentEntity $entity): AttachmentEntity
    {
        $attachment = new AttachmentEntity(
            id: $entity->getId(),
            postId: $entity->getPostId(),
            mimeType: $entity->getMimeType(),
            fileURL: $entity->getFileURL(),
            filePath: $entity->getFilePath(),
            fileName: $entity->getFileName(),
            thumbnailUrl: $entity->getThumbnailUrl(),
            title: $entity->getTitle(),
            description: $entity->getDescription(),
            duration: $entity->getDuration(),
            commentCount: $entity->getCommentCount(),
            reactionCount: $entity->getReactionCount(),
            viewCount: $entity->getViewCount(),
            shareCount: $entity->getShareCount(),
            createdAt: $entity->getCreatedAt(),
            updatedAt: $entity->getUpdatedAt(),
        );

        return $attachment;
    }
}
