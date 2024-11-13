<?php

namespace App\Modules\Post\Domain\Entities;

use App\Modules\Auth\Domain\Entities\UserEntity;
use DateTimeImmutable;


class ViewEntity
{
    private string $id;
    private UserEntity $viewer;
    private DateTimeImmutable $viewedAt;

    public function __construct(
        string $id,
        UserEntity $viewer,
        DateTimeImmutable $viewedAt
    ) {
        $this->id = $id;
        $this->viewer = $viewer;
        $this->viewedAt = $viewedAt;
    }

    public function getId(): string
    {
        return $this->id;
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
