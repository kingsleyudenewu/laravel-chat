<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class RegisterAction
{
    /**
     * Register a new user into the blog system
     *
     * @param array $data
     * @return array
     */
    public function execute(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $user = $this->createUser($data['name'], $data['email'], $data['password']);

            return (new GenerateTokenAction())->execute($user);
        });
    }

    /**
     * Create a user
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @return User
     */
    private function createUser(string $name, string $email, string $password): User
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'email_verified_at' => now(),
        ]);
    }
}
