<?php

namespace App\Modules\Content\Reaction\Domain\ValueObjects;

enum ReactionTypes: string
{
    case LIKE = 'Like';
    case LOVE = 'Love';
    case HAHA = 'Haha';
    case WOW = 'Wow';
    case SAD = 'Sad';
    case ANGRY = 'Angry';
}
