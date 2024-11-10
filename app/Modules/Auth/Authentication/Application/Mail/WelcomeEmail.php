<?php

namespace App\Modules\Auth\Authentication\Application\Mail;

use App\Modules\Auth\Authentication\Domain\Entities\UserEntity;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $user;

    public function __construct(UserEntity $user)
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