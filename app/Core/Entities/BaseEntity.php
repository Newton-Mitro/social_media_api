<?php

namespace App\Core\Entities;

use Ramsey\Uuid\Uuid;


abstract class BaseEntity
{
    protected ?string $id = null;

    public function __construct(?string $id = null)
    {
        // Generate a new ID if one isn't provided
        $this->id = $id ?? Uuid::uuid4()->toString();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }
}
