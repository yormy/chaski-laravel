<?php declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;
use Yormy\Apiresponse\Facades\ApiResponse;
use Yormy\ChaskiLaravel\Domain\Tracking\Repositories\NotificationsSentRepository;
use Yormy\ChaskiLaravel\Domain\Tracking\Resources\NotificationSentCollection;
use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\BaseController;
use Yormy\ChaskiLaravel\Services\Resolvers\UserResolver;

class AdminUserNotificationsSentController extends BaseController
{
    public function index(Request $request, $member_xid)
    {
        $member = UserResolver::getMemberOnXId($member_xid);

        $notificationsSentRepository = new NotificationsSentRepository();
        $notifications = $notificationsSentRepository->getAllForUser($member);

        $notifications = (new NotificationSentCollection($notifications))->toArray($request);
        $notifications = $this->decorateWithStatus($notifications);

        return ApiResponse::withData($notifications)
            ->successResponse();
    }

    private function decorateWithStatus($notifications): array
    {
        foreach ($notifications as $index => $notification) {
            if (array_key_exists('read_at',$notification) && $notification['read_at']) {
                continue;
            }
            $status = [
                'key' => 'unread',
                'nature' => 'danger',
                'text' => __('bedrock-usersv2::status.new'),
            ];

            $notifications[$index]['status'] = $status;
        }

        return $notifications;
    }
}
