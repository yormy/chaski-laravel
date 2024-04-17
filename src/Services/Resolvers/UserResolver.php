<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Services\Resolvers;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Yormy\ChaskiLaravel\Tests\Models\User;
use Illuminate\Support\Facades\Auth;

class UserResolver
{
    public static function getCurrent(): ?Authenticatable
    {
        /**
         * @var User $user
         */
        return Auth::user();
    }

    public static function getMemberById($id): ?Authenticatable
    {
        return User::where('xid', $id)->first();
    }

    public static function getAdminById($id): ?Authenticatable
    {
        return User::where('xid', $id)->first();
    }
}
