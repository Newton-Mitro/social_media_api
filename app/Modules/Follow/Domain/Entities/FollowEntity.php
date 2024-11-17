<?php

namespace App\Modules\Follow\Domain\Entities;

use App\Core\Entities\BaseEntity;

class FollowEntity extends BaseEntity
{
    private string $name;

    public function __construct(string $name, ?string $id = null)
    {
        parent::__construct($id);
        $this->id = $id;
        $this->name = $name;
    }



    public function getName(): string
    {
        return $this->name;
    }
}
