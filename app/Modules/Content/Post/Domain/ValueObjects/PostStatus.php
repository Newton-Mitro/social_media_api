<?php

namespace App\Modules\Content\Post\Domain\ValueObjects;

enum PostStatus: string
{
    case INAPPROPRIATE = 'Inappropriate';
    case APPROVED = 'Approved';
    case REPORTED = 'Reported';
}
