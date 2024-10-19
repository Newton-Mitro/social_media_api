<?php

namespace App\Modules\Auth\Authentication\Listeners;

use App\Modules\Auth\Authentication\Events\UserRegistered;
use App\Modules\Auth\Authentication\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail
{
    public function __construct()
    {
        //
    }

    public function handle(UserRegistered $event): void
    {
        Mail::to($event->user->getEmail())->send(new WelcomeEmail($event->user));
    }
}
