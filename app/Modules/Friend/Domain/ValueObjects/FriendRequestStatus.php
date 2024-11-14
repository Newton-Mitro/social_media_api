<?php

namespace App\Modules\Friend\Domain\ValueObjects;

enum FriendRequestStatus: string
{
    case PENDING = 'Pending';
    case ACCEPTED = 'Accepted';
    case REJECTED = 'Rejected';
}
