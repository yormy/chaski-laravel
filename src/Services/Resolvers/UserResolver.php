<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Services\Resolvers;

use Illuminate\Support\Facades\Auth;
use Mexion\BedrockUsersv2\Domain\User\Models\Admin;
use Mexion\BedrockUsersv2\Domain\User\Models\Member;

class UserResolver
{
    public static function getCurrent(): Admin|Member|null
    {
        /**
         * @var User $user
         */
        $user = Auth::user();

        return $user;
    }

    public static function getMemberById($id)
    {
        return Member::where('xid', $id)->first();
    }

    public static function getAdminById($id)
    {
        return Admin::where('xid', $id)->first();
    }
}
