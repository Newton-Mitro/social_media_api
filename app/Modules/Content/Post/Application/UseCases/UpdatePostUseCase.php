<?php

namespace App\Modules\Content\Post\Application\UseCases;

use App\Modules\Content\Attachment\Domain\Entities\AttachmentEntity;
use App\Modules\Content\Attachment\Domain\Repositories\AttachmentRepositoryInterface;
use App\Modules\Content\Post\Application\DTOs\PostAggregateDTO;
use App\Modules\Content\Post\Application\Mappers\PostAggregateMapper;
use App\Modules\Content\Post\Application\Requests\UpdatePostRequest;
use App\Modules\Content\Post\Domain\Repositories\PostRepositoryInterface;
use App\Modules\Content\Privacy\Domain\Repositories\PrivacyRepositoryInterface;
use DateTimeImmutable;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdatePostUseCase
{
    public function __construct(
        protected PostRepositoryInterface $postRepository,
        protected AttachmentRepositoryInterface $attachmentRepository,
        protected PrivacyRepositoryInterface $privacyRepository,
    ) {}

    public function handle(UpdatePostRequest $request, $postId): PostAggregateDTO
    {
        // Fetch the existing PostAggregate
        $postAggregate = $this->postRepository->findById($postId);

        if (!$postAggregate) {
            throw new NotFoundHttpException("Post with ID $postId not found.");
        }

        // Update content and privacy
        if ($request->has('post_text')) {
            $postAggregate->setPostText($request->get('post_text'));
        }

        if ($request->has('privacy_id')) {
            $privacyEntity = $this->privacyRepository->findById($request->get('privacy_id'));
            $postAggregate->setPrivacy($privacyEntity);
        }

        $postAggregate->setUpdatedAt(new DateTimeImmutable());

        // Handle attachments to delete
        if ($request->has('delete_attachments')) {
            foreach ($request->get('delete_attachments') as $attachmentId) {
                $attachmentEntity = null;

                // Search for the attachment in the aggregate's attachments array
                foreach ($postAggregate->getAttachments() as $index => $attachment) {
                    if ($attachment->getId() === $attachmentId) {
                        $attachmentEntity = $attachment;
                        break;
                    }
                }

                if ($attachmentEntity) {
                    // Delete the attachment file
                    Storage::disk('public')->delete($attachmentEntity->getFilePath());

                    // Remove the attachment from the aggregate
                    $postAggregate->removeAttachment($attachmentEntity);
                }
            }
        }

        // Handle new attachments
        if ($request->has('attachments')) {
            foreach ($request->attachments as $attachment) {
                $path = $attachment->store('uploads', 'public');
                $attachmentEntity = new AttachmentEntity(
                    postId: $postAggregate->getId(),
                    fileName: $attachment->getClientOriginalName(),
                    fileURL: asset(Storage::url($path)),
                    filePath: $path,
                    mimeType: $attachment->getMimeType()
                );
                $postAggregate->addAttachment($attachmentEntity);
            }
        }

        // Persist the changes
        $this->postRepository->update($postAggregate);
        $post = $this->postRepository->findById($postAggregate->getId());

        return PostAggregateMapper::toDTO($post);
    }
}
