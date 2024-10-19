<?php

namespace App\Features\Auth\Authentication\Mail;

use App\Features\Auth\User\BusinessModels\UserModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $user;

    public function __construct(UserModel $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this
            ->view('emails.welcome')
            ->with([
                'name' => $this->user->getName(),
            ]);
    }
}
