<?php

namespace App\Modules\Auth\Infrastructure\Mail;

use App\Modules\Auth\Domain\Entities\UserAggregate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $user;

    public function __construct(UserAggregate $user)
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
