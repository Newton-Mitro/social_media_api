<?php

namespace App\Modules\Content\Attachment\Application\UseCases;

use App\Modules\Content\Attachment\Domain\Repositories\AttachmentRepositoryInterface;

class ReactToAttachmentUseCase
{

    public function __construct(protected AttachmentRepositoryInterface $attachmentRepository) {}

    public function execute(array $data): void {}
}
