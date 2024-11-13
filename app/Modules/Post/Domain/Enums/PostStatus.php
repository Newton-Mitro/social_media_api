<?php

namespace App\Modules\Post\Domain\Enums;

enum PostStatus: string
{
    case INAPPROPRIATE = 'Inappropriate';
    case APPROVED = 'Approved';
    case REPORTED = 'Reported';
}
