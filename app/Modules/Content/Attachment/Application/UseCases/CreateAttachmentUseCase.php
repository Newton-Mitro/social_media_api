<?php

namespace App\Modules\Content\Attachment\Application\UseCases;

use App\Modules\Content\Attachment\Application\DTOs\AttachmentDTO;
use App\Modules\Content\Attachment\Domain\Entities\AttachmentEntity;
use App\Modules\Content\Attachment\Domain\Repositories\AttachmentRepositoryInterface;

class CreateAttachmentUseCase
{
    private AttachmentRepositoryInterface $repository;

    public function __construct(AttachmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(array $data): AttachmentDTO
    {

        $attachment = new AttachmentEntity(
            id: $data['id'],
            postId: $data['post_id'],
            mimeType: $data['mime_type'],
            fileURL: $data['file_url'],
            filePath: $data['file_path'] ?? null,
            fileName: $data['file_name'] ?? null,
            thumbnailUrl: $data['thumbnail_url'] ?? null,
            title: $data['title'] ?? null,
            description: $data['description'] ?? null,
            duration: $data['duration'] ?? null,
            commentCount: 0,
            reactionCount: 0,
            viewCount: 0,
            shareCount: 0,
            createdAt: new \DateTimeImmutable(),
            updatedAt: new \DateTimeImmutable(),
        );

        $savedAttachment = $this->repository->save($attachment);

        $attachmentDTO = new AttachmentDTO();
        $attachmentDTO->id = $savedAttachment->getId();
        $attachmentDTO->post_id = $savedAttachment->getPostId();
        $attachmentDTO->mime_type = $savedAttachment->getMimeType();
        $attachmentDTO->file_url = $savedAttachment->getFileURL();
        $attachmentDTO->file_path = $savedAttachment->getFilePath();
        $attachmentDTO->file_name = $savedAttachment->getFileName();
        $attachmentDTO->thumbnail_url = $savedAttachment->getThumbnailURL();
        $attachmentDTO->title = $savedAttachment->getTitle();
        $attachmentDTO->description = $savedAttachment->getDescription();
        $attachmentDTO->duration = $savedAttachment->getDuration();
        $attachmentDTO->comment_count = $savedAttachment->getCommentCount();
        $attachmentDTO->reaction_count = $savedAttachment->getReactionCount();
        $attachmentDTO->view_count = $savedAttachment->getViewCount();
        $attachmentDTO->share_count = $savedAttachment->getShareCount();
        $attachmentDTO->created_at = $savedAttachment->getCreatedAt();
        $attachmentDTO->updated_at = $savedAttachment->getUpdatedAt();

        return $attachmentDTO;
    }
}
