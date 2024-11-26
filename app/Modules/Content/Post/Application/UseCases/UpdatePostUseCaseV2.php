<?php

namespace App\Modules\Content\Post\Application\UseCases;

use App\Modules\Content\Attachment\Domain\Entities\AttachmentEntity;
use App\Modules\Content\Attachment\Domain\Repositories\AttachmentRepositoryInterface;
use App\Modules\Content\Post\Application\DTOs\PostAggregateDTO;
use App\Modules\Content\Post\Application\Mappers\PostAggregateMapper;
use App\Modules\Content\Post\Application\Requests\UpdatePostRequestV2;
use App\Modules\Content\Post\Domain\Repositories\PostRepositoryInterface;
use App\Modules\Content\Privacy\Domain\Repositories\PrivacyRepositoryInterface;
use DateTimeImmutable;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UpdatePostUseCaseV2
{
    public function __construct(
        protected PostRepositoryInterface $postRepository,
        protected AttachmentRepositoryInterface $attachmentRepository,
        protected PrivacyRepositoryInterface $privacyRepository,
    ) {}

    public function handle(UpdatePostRequestV2 $request, $postId): PostAggregateDTO
    {
        // Fetch the existing PostAggregate
        $postAggregate = $this->postRepository->findById($postId);

        if (!$postAggregate) {
            throw new NotFoundHttpException("Post with ID $postId not found.", null, Response::HTTP_NOT_FOUND);
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
                    // Remove the attachment from the aggregate
                    $postAggregate->removeAttachment($attachmentEntity);
                }
            }
        }

        // Handle new attachments
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

        // Persist the changes
        $this->postRepository->update($postAggregate);
        $post = $this->postRepository->findById($postAggregate->getId());

        return PostAggregateMapper::toDTO($post);
    }
}
