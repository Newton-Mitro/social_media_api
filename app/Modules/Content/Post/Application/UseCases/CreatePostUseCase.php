<?php

namespace App\Modules\Content\Post\Application\UseCases;

use App\Core\Utilities\FileUtil;
use App\Modules\Auth\Domain\Interfaces\UserRepositoryInterface;
use App\Modules\Content\Attachment\Domain\Entities\AttachmentEntity;
use App\Modules\Content\Attachment\Domain\Repositories\AttachmentRepositoryInterface;
use App\Modules\Content\Post\Application\DTOs\PostAggregateDTO;
use App\Modules\Content\Post\Application\Mappers\PostAggregateMapper;
use App\Modules\Content\Post\Application\Requests\StorePostRequest;
use App\Modules\Content\Post\Domain\Aggregates\PostAggregate;
use App\Modules\Content\Post\Domain\Repositories\PostRepositoryInterface;
use App\Modules\Content\Privacy\Domain\Repositories\PrivacyRepositoryInterface;
use DateTimeImmutable;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Symfony\Component\CssSelector\Exception\InternalErrorException;


class CreatePostUseCase
{
    public function __construct(
        protected PostRepositoryInterface $postRepository,
        protected AttachmentRepositoryInterface $attachmentRepository,
        protected PrivacyRepositoryInterface $privacyRepository,
        protected UserRepositoryInterface $userRepository
    ) {}

    public function handle(StorePostRequest $request): PostAggregateDTO
    {
        // Extract data from request
        $authId = $request->get('uid');

        // Find privacy by id
        $privacyEntity = $this->privacyRepository->findById($request->get('privacy_id'));

        $creator = $this->userRepository->findById($authId);

        // Create PostAggregate
        $postAggregate = new PostAggregate(
            postText: $request->get('post_text'),
            creator: $creator,
            privacy: $privacyEntity,
            createdAt: new DateTimeImmutable(),
            updatedAt: new DateTimeImmutable()
        );



        // Handle attachments
        if ($request->has('attachments')) {

            foreach ($request->attachments as $file) {
                $path = $file->store('uploads', 'public');

                // Extract file details
                $fileName = basename($path);
                $fileExtension = $file->getClientOriginalExtension();
                $thumbnail_url = null;
                $duration = 0;
                $thumbnailPath = null;


                // Process based on file type
                if (FileUtil::isImage($file)) {
                    $thumbnailPath = FileUtil::createImageThumbnail($path, $fileName, $fileExtension);
                    $thumbnail_url = asset(Storage::url($thumbnailPath));
                } elseif (FileUtil::isVideo($file)) {
                    $thumbnailPath = FileUtil::createVideoThumbnail($path, $fileName);
                    $thumbnail_url = asset(Storage::url($thumbnailPath));

                    // Optionally, calculate video duration
                    $duration = FileUtil::getVideoDuration($path);
                }

                $path = $file->store('uploads', 'public');
                $attachmentEntity = new AttachmentEntity(
                    postId: $postAggregate->getId(),
                    fileName: $fileName,
                    fileURL: asset(Storage::url($path)),
                    filePath: $path,
                    mimeType: $file->getMimeType(),
                    thumbnailUrl: $thumbnail_url,
                    duration: $duration
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
