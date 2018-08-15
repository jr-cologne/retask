<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    public function forEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function forActivation(string $email, string $activation_token)
    {
        return $this->forEmail($email)->where('activation_token', $activation_token)->firstOrFail();
    }

    public function updateForActivation(User $user)
    {
        $user->update([
            'active' => true,
            'activation_token' => null
        ]);
    }
}
