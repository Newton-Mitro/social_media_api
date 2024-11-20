<?php

namespace App\Modules\Content\Attachment\Domain\Repositories;

use App\Modules\Content\Attachment\Domain\Entities\AttachmentEntity;
use Illuminate\Support\Collection;


interface AttachmentRepositoryInterface
{
    public function getAll(): Collection;
    public function findById(string $id): ?AttachmentEntity;
    public function save(AttachmentEntity $attachment): AttachmentEntity;
    public function update(string $id, array $data): bool;
    public function delete(string $id): bool;
}
