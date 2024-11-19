<?php

namespace App\Modules\Content\Privacy\Domain\Entities;

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
