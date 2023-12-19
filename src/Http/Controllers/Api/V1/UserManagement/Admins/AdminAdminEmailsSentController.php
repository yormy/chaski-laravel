<?php declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Http\Controllers\Api\V1\UserManagement\Admins;

use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\UserManagement\Base\BaseAdminUserEmailsSentController;
use Yormy\ChaskiLaravel\Services\Resolvers\UserResolver;

class AdminAdminEmailsSentController extends BaseAdminUserEmailsSentController
{
    public function getUser($member_xid)
    {
        return UserResolver::getAdminById($member_xid);
    }
}
