<?php

namespace App\Modules\Auth\Application\Events;

use App\Modules\Auth\Domain\Entities\UserAggregate;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRegistered
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public UserAggregate $user) {}
}
