<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Http\Controllers\Api\V1\Traits;

trait NotificationsSentDecoratorTrait
{
    private function decorateWithStatus($notifications): array
    {
        foreach ($notifications as $index => $notification) {
            if (array_key_exists('read_at', $notification) && $notification['read_at']) {
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
