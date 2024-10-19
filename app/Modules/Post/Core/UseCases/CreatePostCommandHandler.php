<?php

namespace App\Modules\Post\UseCases\Commands\CreatePost;

use App\Modules\Post\BusinessModels\AttachmentModel;
use App\Modules\Post\BusinessModels\PostModel;
use App\Modules\Post\Interfaces\PostRepositoryInterface;

class CreatePostCommandHandler
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

        // $postModel = new PostModel(
        //     postId: 0,
        //     userId: $command->getUserId(),
        //     body: $command->getBody(),
        //     privacyId: $command->getPrivacyId(),
        //     createdBy: $command->getUserId(),
        //     attachments: $attachmentModels,
        // );
        // Persist user in database
        // $res = $this->repository->create($postModel);

        // return $res;
        return '';
    }
}
