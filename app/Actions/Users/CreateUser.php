<?php

namespace App\Actions\Users;

use App\Entities\UserDTO;
use App\Models\User;
use Illuminate\Support\Str;

class CreateUser
{
    public static function run(UserDTO $user, bool $is_admin = false): UserDTO
    {
        /** @var User $newUser */
        $newUser = User::query()
            ->create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => bcrypt($user->password),
                'is_admin' => $is_admin,
                'api_key' => Str::random(15)
            ]);

        return UserDTO::from([
            'name' => $newUser->name,
            'email' => $newUser->email,
            'password' => $newUser->password,
            'is_admin' => $newUser->is_admin,
            'api_key' => $newUser->api_key,
            'token' => $newUser->handleTokens()
        ]);
    }
}
