<?php

namespace App\Modules\Content\Attachment\Application\UseCases;

use App\Modules\Content\Attachment\Application\Mappers\AttachmentMapper;
use App\Modules\Content\Attachment\Domain\Repositories\AttachmentRepositoryInterface;
use Exception;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


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
            throw new NotFoundHttpException("Attachment not found with this id $id.", null, Response::HTTP_NOT_FOUND);
        }
        return AttachmentMapper::toDTO($attachment);
    }
}
