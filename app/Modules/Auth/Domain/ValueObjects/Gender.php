<?php

namespace App\Modules\Auth\Domain\ValueObjects;

enum Gender: string
{
    case MALE = 'Male';
    case FEMALE = 'Female';
    case OTHERS = 'Others';
}
