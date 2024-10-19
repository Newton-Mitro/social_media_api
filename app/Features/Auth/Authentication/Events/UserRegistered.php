<?php

namespace App\Features\Auth\Authentication\Events;

use App\Features\Auth\User\BusinessModels\UserModel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRegistered
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public UserModel $user) {}
}
