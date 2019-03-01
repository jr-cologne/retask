<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserRepository
 *
 * @package App\Repositories
 */
class UserRepository
{
    /**
     * @param string $email
     * @return mixed
     */
    public function forEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    /**
     * @param string $email
     * @param string $activation_token
     * @return mixed
     */
    public function forActivation(string $email, string $activation_token)
    {
        return $this->forEmail($email)->where('activation_token', $activation_token)->firstOrFail();
    }

    /**
     * @param User $user
     */
    public function updateForActivation(User $user)
    {
        $user->update([
            'active' => true,
            'activation_token' => null
        ]);
    }

    /**
     * @param array $data
     * @param User $user
     */
    public function update(array $data, User $user)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
    }

    /**
     * @param User $user
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}
