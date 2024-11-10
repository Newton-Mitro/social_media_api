<?php

namespace App\Modules\Auth\Authentication\Application\Events;

use App\Modules\Auth\Authentication\Domain\Entities\UserEntity;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRegistered
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public UserEntity $user) {}
}
