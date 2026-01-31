<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Аутентификация пользователя по email и паролю
     *
     * @param string $email
     * @param string $password
     * @return string
     */
    public function login(string $email, string $password): string
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'email' => $email,
                'password' => Hash::make($password),
            ]);
        } else {
            if (!Hash::check($password, $user->password)) {
                return '';
            }
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return $token;
    }
}
