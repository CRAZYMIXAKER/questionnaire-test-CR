<?php

declare(strict_types=1);

namespace App\Services;

use App\Events\UserUpdated;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class UserService
{

    /**
     * @param  string  $email
     *
     * @return \App\Models\User
     */
    public static function getUserByEmail(string $email): User
    {
        return User::where('email', $email)->first();
    }

    /**
     * @param  \App\Models\User|null  $user
     *
     * @return \App\Models\User|null
     */
    public static function prepareUserBroadcastData(?User $user): ?User
    {
        if (isset($user->password)) {
            unset($user->password);
        }

        $user?->getRoleNames();

        return $user;
    }

    /**
     * @param $user
     *
     * @return void
     */
    public static function sendUserBroadcast($user): void
    {
        broadcast(new UserUpdated(self::prepareUserBroadcastData($user)));
    }

}
