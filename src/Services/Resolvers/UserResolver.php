<?php declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Services\Resolvers;

use Illuminate\Support\Facades\Auth;
use Mexion\BedrockUsersv2\Domain\User\Models\User;

class UserResolver
{
    public static function getCurrent() : ?User
    {
        /**
         * @var User $user
         */
        $user = Auth::user();

        return $user;
    }
}
