<?php

namespace App\Modules\Content\View\Domain\Entities;

use App\Core\Entities\BaseEntity;
use App\Modules\Auth\Domain\Entities\UserEntity;
use DateTimeImmutable;


class ViewEntity extends BaseEntity
{
    private UserEntity $viewer;
    private DateTimeImmutable $viewedAt;

    public function __construct(
        UserEntity $viewer,
        DateTimeImmutable $viewedAt,
        ?string $id = null,
    ) {
        parent::__construct($id);
        $this->viewer = $viewer;
        $this->viewedAt = $viewedAt;
    }


    public function getViewer(): UserEntity
    {
        return $this->viewer;
    }

    public function getViewedAt(): DateTimeImmutable
    {
        return $this->viewedAt;
    }
}
