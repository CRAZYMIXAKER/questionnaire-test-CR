<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\UserUpdated;
use App\Models\User;

class UserService
{
    /**
     * @param  string  $email
     *
     * @return void
     */
    public function getUserByEmailAndBroadcast(string $email): void
    {
        $user = User::where('email', $email)
          ->select('name', 'email')
          ->first();

        broadcast(new UserUpdated($user->toArray()));
    }
}
