<?php

namespace App\Modules\Post\Domain\Enums;

enum ReactionTypes: string
{
    case LIKE = 'Like';
    case LOVE = 'Love';
    case HAHA = 'Haha';
    case WOW = 'Wow';
    case SAD = 'Sad';
    case ANGRY = 'Angry';
}
