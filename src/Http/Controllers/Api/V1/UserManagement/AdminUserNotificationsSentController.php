<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Http\Controllers\Api\V1\UserManagement;

use Yormy\ChaskiLaravel\Services\Resolvers\UserResolver;

class AdminUserNotificationsSentController extends BaseAdminUserNotificationsSentController
{
    public function getUser($xid)
    {
        return UserResolver::getMemberById($xid);
    }
}
