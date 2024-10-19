<?php

namespace App\Features\Auth\Authentication\Listeners;

use App\Features\Auth\Authentication\Events\UserRegistered;
use App\Features\Auth\Authentication\Mail\WelcomeEmail;
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
