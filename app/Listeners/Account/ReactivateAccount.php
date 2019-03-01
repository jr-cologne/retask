<?php

namespace App\Listeners\Account;

use App\Events\Account\UserUpdatedEmail;
use Illuminate\Auth\Events\Registered;

/**
 * Class DeactivateAccount
 *
 * @package App\Listeners\Account
 */
class ReactivateAccount
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
     * @param UserUpdatedEmail $event
     * @return void
     */
    public function handle(UserUpdatedEmail $event)
    {
        $event->user->deactivateAccount();

        // pretend user was registered
        event(new Registered($event->user));
    }
}
