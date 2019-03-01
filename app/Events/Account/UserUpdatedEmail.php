<?php

namespace App\Events\Account;

use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

/**
 * Class UserUpdatedEmail
 *
 * @package App\Events\Account
 */
class UserUpdatedEmail
{
    use Dispatchable, SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
