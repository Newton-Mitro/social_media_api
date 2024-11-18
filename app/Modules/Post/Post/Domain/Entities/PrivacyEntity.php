<?php

namespace App\Modules\Post\Domain\Entities;

use App\Core\Entities\BaseEntity;

class PrivacyEntity extends BaseEntity
{

    private string $name;

    public function __construct(string $name, ?string $id = null)
    {
        parent::__construct($id);
        $this->name = $name;
    }



    public function getName(): string
    {
        return $this->name;
    }
}
