<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Http\Controllers\Api\V1\Traits;

trait EmailsSentDecoratorTrait
{
    private function decorateWithStatus($emails): array
    {
        foreach ($emails as $index => $data) {
            if (array_key_exists('opened_at', $data) && $data['opened_at']) {
                continue;
            }

            $status = [
                'key' => 'unread',
                'nature' => 'danger',
                'text' => __('bedrock-usersv2::status.new'),
            ];

            $emails[$index]['status'] = $status;
        }

        return $emails;
    }
}
