<?php

namespace App\Modules\Content\Attachment\Application\UseCases;

use App\Modules\Content\Attachment\Domain\Repositories\AttachmentRepositoryInterface;


class GetAttachmentUseCase
{

    public function __construct(protected AttachmentRepositoryInterface $attachmentRepository) {}

    public function getAll()
    {
        return $this->attachmentRepository->getAll();
    }

    public function findById(string $id)
    {
        return $this->attachmentRepository->findById($id);
    }
}
