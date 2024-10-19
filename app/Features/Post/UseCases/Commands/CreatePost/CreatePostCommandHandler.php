<?php

namespace App\Features\Post\UseCases\Commands\CreatePost;

use App\Core\Bus\CommandHandler;
use App\Features\Post\BusinessModels\AttachmentModel;
use App\Features\Post\BusinessModels\PostModel;
use App\Features\Post\Interfaces\PostRepositoryInterface;

class CreatePostCommandHandler extends CommandHandler
{
    public function __construct(
        protected PostRepositoryInterface $repository,
    ) {}

    public function handle(CreatePostCommand $command): string
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
            postId: 0,
            userId: $command->getUserId(),
            body: $command->getBody(),
            privacyId: $command->getPrivacyId(),
            createdBy: $command->getUserId(),
            attachments: $attachmentModels,
        );
        // Persist user in database
        $res = $this->repository->create($postModel);

        return $res;
    }
}
