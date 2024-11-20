<?php

namespace App\Modules\Content\Attachment\Application\UseCases;

use App\Modules\Content\Attachment\Domain\Repositories\AttachmentRepositoryInterface;


class DeleteAttachmentUseCase
{

    public function __construct(protected AttachmentRepositoryInterface $attachmentRepository) {}

    public function execute(string $id): bool
    {
        return $this->attachmentRepository->delete($id);
    }
}
