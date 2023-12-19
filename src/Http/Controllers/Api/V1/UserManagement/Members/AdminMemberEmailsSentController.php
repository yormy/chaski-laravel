<?php declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Http\Controllers\Api\V1\UserManagement\Members;

use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\UserManagement\Base\BaseAdminUserEmailsSentController;
use Yormy\ChaskiLaravel\Services\Resolvers\UserResolver;

class AdminMemberEmailsSentController extends BaseAdminUserEmailsSentController
{
    public function getUser($member_xid)
    {
        return UserResolver::getMemberById($member_xid);
    }
}
