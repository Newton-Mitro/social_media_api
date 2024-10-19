<?php

namespace App\Features\Post\UseCases\Commands\UpdatePost;

use App\Features\Post\BusinessModels\AttachmentModel;
use App\Features\Post\BusinessModels\PostModel;
use App\Features\Post\Interfaces\PostRepositoryInterface;

class UpdatePostCommandHandler
{
    public function __construct(
        protected PostRepositoryInterface $repository,
    ) {}

    public function handle(UpdatePostCommand $command): string
    {
        $attachments = $command->getAttachments();
        $attachmentModels = [];

        foreach ($attachments as $attachment) {
            $attachmentModel = new AttachmentModel(
                0,
                0,
                $attachment['content_name'],
                $attachment['content_url'],
                $attachment['content_url'] . $attachment['content_name'],
                $attachment['content_type'],
                $command->getUserId()
            );
            $attachmentModels[] = $attachmentModel;
        }

        $postModel = new PostModel(
            postId: $command->getPostId(),
            userId: $command->getUserId(),
            body: $command->getBody(),
            existing_content_url: $command->getExistingContentUrl(),
            privacyId: $command->getPrivacyId(),
            createdBy: $command->getUserId(),
            attachments: $attachmentModels,
        );
        $res = $this->repository->update($postModel);
        return $res;
    }
}
