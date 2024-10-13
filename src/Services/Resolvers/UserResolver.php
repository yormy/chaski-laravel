<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Services\Resolvers;

use Illuminate\Foundation\Auth\User as Authenticatable;
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
        $model = config('chaski.models.member');
        return $model::where('xid', $id)->first();
    }

    public static function getAdminById($id): ?Authenticatable
    {
        $model = config('chaski.models.admin');
        return $model::where('xid', $id)->first();
    }
}
