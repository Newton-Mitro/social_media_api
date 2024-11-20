<?php

namespace App\Modules\Content\Attachment\Application\UseCases;

use App\Modules\Content\Attachment\Domain\Repositories\AttachmentRepositoryInterface;


class UpdateAttachmentUseCase
{

    public function __construct(protected AttachmentRepositoryInterface $attachmentRepository) {}

    public function execute(string $id, array $data): bool
    {
        return $this->attachmentRepository->update($id, $data);
    }
}
