<?php

namespace App\Actions;

use Illuminate\Support\Facades\DB;

class RegisterAction
{
    public function execute(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = $this->createUser($data['name'], $data['email'], $data['password']);

            $this->createUserLedger($user);

            return (new GenerateTokenAction())->execute($user);
        });
    }
}
