<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Http\Controllers\Api\V1\UserManagement;

use Illuminate\Http\Request;
use Yormy\Apiresponse\Facades\ApiResponse;
use Yormy\ChaskiLaravel\Domain\Tracking\Repositories\NotificationsSentRepository;
use Yormy\ChaskiLaravel\Domain\Tracking\Resources\NotificationSentCollection;
use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\BaseController;
use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\Traits\NotificationsSentDecoratorTrait;

class BaseAdminUserNotificationsSentController extends BaseController
{
    use NotificationsSentDecoratorTrait;

    public function index(Request $request, $member_xid)
    {
        $user = $this->getUser($member_xid);

        $notificationsSentRepository = new NotificationsSentRepository();
        $notifications = $notificationsSentRepository->getAllForUser($user);

        $notifications = (new NotificationSentCollection($notifications))->toArray($request);
        $notifications = $this->decorateWithStatus($notifications);

        return ApiResponse::withData($notifications)
            ->successResponse();
    }
}
