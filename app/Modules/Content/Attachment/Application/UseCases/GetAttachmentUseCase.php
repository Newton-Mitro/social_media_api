<?php

namespace App\Modules\Content\Attachment\Application\UseCases;

use App\Modules\Content\Attachment\Application\Mappers\AttachmentMapper;
use App\Modules\Content\Attachment\Domain\Repositories\AttachmentRepositoryInterface;
use Exception;
use Illuminate\Http\Response;


class GetAttachmentUseCase
{

    public function __construct(protected AttachmentRepositoryInterface $attachmentRepository) {}

    public function getAll()
    {
        return AttachmentMapper::toDTOCollection($this->attachmentRepository->getAll());
    }

    public function findById(string $id)
    {
        $attachment = $this->attachmentRepository->findById($id);
        if (!$attachment) {
            throw new Exception("Attachment not found.", Response::HTTP_NOT_FOUND);
        }
        return AttachmentMapper::toDTO($attachment);
    }
}
