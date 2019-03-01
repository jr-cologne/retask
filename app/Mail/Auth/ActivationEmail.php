<?php

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\User;

/**
 * Class ActivationEmail
 *
 * @package App\Mail\Auth
 */
class ActivationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * ActivationEmail constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return ActivationEmail
     */
    public function build()
    {
        return $this->markdown('emails.auth.activation');
    }
}
