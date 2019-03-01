<?php

namespace App\Listeners\Auth;

use App\Events\Auth\UserRequestedActivationEmail;
use Illuminate\Support\Facades\Mail;

use App\Mail\Auth\ActivationEmail;

/**
 * Class SendActivationEmail
 *
 * @package App\Listeners\Auth
 */
class SendActivationEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRequestedActivationEmail  $event
     * @return void
     */
    public function handle(UserRequestedActivationEmail $event)
    {
        if ($event->user->active) {
            return;
        }

        Mail::to($event->user->email)->send(new ActivationEmail($event->user));
    }
}
