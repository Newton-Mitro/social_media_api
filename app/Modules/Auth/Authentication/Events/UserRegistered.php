<?php

namespace App\Modules\Auth\Authentication\Events;

use App\Modules\Auth\User\BusinessModels\UserModel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRegistered
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public UserModel $user) {}
}
