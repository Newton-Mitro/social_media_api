<?php

namespace App\Modules\Post\Domain\Entities;

use App\Modules\Auth\User\Domain\Entities\UserEntity;

class ViewEntity
{
    private string $id;
    private UserEntity $viewer; // User who viewed the post
    private \DateTimeImmutable $viewedAt; // Time when the post was viewed

    // Constructor to initialize the ViewEntity
    public function __construct(
        string $id,
        UserEntity $viewer,
        \DateTimeImmutable $viewedAt
    ) {
        $this->id = $id;
        $this->viewer = $viewer;
        $this->viewedAt = $viewedAt;
    }

    // Getters for the properties
    public function getId(): string
    {
        return $this->id;
    }

    public function getViewer(): UserEntity
    {
        return $this->viewer;
    }

    public function getViewedAt(): \DateTimeImmutable
    {
        return $this->viewedAt;
    }
}
