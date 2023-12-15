<?php declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Http\Controllers\Api\V1\Member;

use Illuminate\Http\Request;
use Yormy\Apiresponse\Facades\ApiResponse;
use Yormy\ChaskiLaravel\Domain\Tracking\Repositories\NotificationsSentRepository;
use Yormy\ChaskiLaravel\Domain\Tracking\Resources\NotificationSentCollection;
use Yormy\ChaskiLaravel\Domain\Tracking\Resources\NotificationSentResource;
use Yormy\ChaskiLaravel\Http\Controllers\Api\V1\BaseController;
use Yormy\ChaskiLaravel\Http\Requests\MarkNotificationOpenedRequest;

class NotificationsSentController extends BaseController
{
    public function index(Request $request)
    {
        $notificationsSentRepository = new NotificationsSentRepository();
        $notifications = $notificationsSentRepository->getAllForUser($this->user);

        $notifications = (new NotificationSentCollection($notifications))->toArray($request);
        $notifications = $this->decorateWithStatus($notifications);

        return ApiResponse::withData($notifications)
            ->successResponse();
    }

    public function attention(Request $request)
    {
        $notificationsSentRepository = new NotificationsSentRepository();
        $notifications = $notificationsSentRepository->getAllNewForUser($this->user);

        $notifications = (new NotificationSentCollection($notifications))->toArray($request);

        $notificationData = $this->buildMenuData($notifications);

        return ApiResponse::withData($notificationData)
            ->successResponse();
    }

    private function buildMenuData(array $notifications): array
    {
        $button = [
            'type' => 'danger',
            'content' => sizeof($notifications),
            'icon' => 'y-icon icon icon-notification',
        ];

        $header = [
            "title" => __('bedrock-usersv2::menu.top.notifications.title', ['count' => sizeof($notifications)]),
        ];

        $items = [];
        foreach ($notifications as $notification) {
            $items[] = $this->buildMenuItem($notification);
        }

        return [
            'button' => $button,
            'header' => $header,
            'items' => $items,
        ];
    }

    private function buildMenuItem(array $item): array
    {
        return [
            "id" => $item['id'],
            'image' => [
                "file" => array_key_exists('image_file', $item) ? $item['image_file'] : null,
                "name" => array_key_exists('image_name', $item) ? $item['image_name'] : null,
            ],
            "title" => $item['title'],
            "subtitle" => $item['content'],
            "date" => $item['created_at_human'],
            "web_cta" => array_key_exists('web_cta', $item) ? $item['web_cta'] : null,
            "sent_email_id" => array_key_exists('sent_email_id', $item) ? $item['sent_email_id'] : null,
        ];
    }

    public function markOpened(MarkNotificationOpenedRequest $request, string $id)
    {
        $notificationsSentRepository = new NotificationsSentRepository();
        $notification = $notificationsSentRepository->markReadForUser($this->user, $id);
        $notification = (new NotificationSentResource($notification))->toArray($request);

        return ApiResponse::withData($notification)
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
