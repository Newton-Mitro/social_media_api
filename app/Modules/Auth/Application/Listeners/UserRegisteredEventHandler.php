<?php

namespace App\Modules\Auth\Application\Listeners;

use App\Modules\Auth\Application\Events\UserRegistered;
use App\Modules\Auth\Infrastructure\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

class UserRegisteredEventHandler
{
    public function handle(UserRegistered $event): void
    {
        // Send welcome email
        Mail::to($event->user->getEmail())->send(new WelcomeEmail($event->user));
    }
}
