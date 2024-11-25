<?php

namespace App\Modules\Content\Post\Application\UseCases;

use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Content\Attachment\Domain\Entities\AttachmentEntity;
use App\Modules\Content\Attachment\Domain\Repositories\AttachmentRepositoryInterface;
use App\Modules\Content\Post\Application\DTOs\PostAggregateDTO;
use App\Modules\Content\Post\Application\Mappers\PostAggregateMapper;
use App\Modules\Content\Post\Application\Requests\StorePostRequestV2;
use App\Modules\Content\Post\Domain\Aggregates\PostAggregate;
use App\Modules\Content\Post\Domain\Repositories\PostRepositoryInterface;
use App\Modules\Content\Privacy\Domain\Repositories\PrivacyRepositoryInterface;
use DateTimeImmutable;
use Illuminate\Support\Facades\Storage;


class CreatePostUseCaseV2
{
    public function __construct(
        protected PostRepositoryInterface $postRepository,
        protected AttachmentRepositoryInterface $attachmentRepository,
        protected PrivacyRepositoryInterface $privacyRepository,
        protected UserRepositoryInterface $userRepository
    ) {}

    public function handle(StorePostRequestV2 $request): PostAggregateDTO
    {
        // Extract data from request
        $authId = $request->get('uid');

        // Find privacy by id
        $privacyEntity = $this->privacyRepository->findById($request->get('privacy_id'));

        $creator = $this->userRepository->findById($authId);

        // Create PostAggregate
        $postAggregate = new PostAggregate(
            postText: $request->input('post_text'),
            creator: $creator,
            privacy: $privacyEntity,
            createdAt: new DateTimeImmutable(),
            updatedAt: new DateTimeImmutable()
        );

        // Handle attachments
        if ($request->has('attachments')) {
            foreach ($request->attachments as $attachment) {
                $attachmentEntity = new AttachmentEntity(
                    postId: $postAggregate->getId(),
                    fileName: $attachment['file_name'],
                    fileURL: $attachment['file_url'],
                    filePath: $attachment['file_path'],
                    mimeType: $attachment['mime_type'],
                );
                $postAggregate->addAttachment($attachmentEntity);
            }
        }

        // Save the post
        $this->postRepository->save($postAggregate);

        $post = $this->postRepository->findById($postAggregate->getId());

        return PostAggregateMapper::toDTO($post);
    }
}
