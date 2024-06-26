<?php

namespace Yormy\ChaskiLaravel\Tests\Traits;

use Yormy\ChaskiLaravel\Tests\Models\User;

trait UserTrait
{
    private function createUser()
    {
        $user = User::create([
            'firstname' => 'FirstName',
            'email' => 'test@exampel.com',
        ]);

        return $user;
    }
}
