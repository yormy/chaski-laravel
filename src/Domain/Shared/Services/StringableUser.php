<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Shared\Services;

class StringableUser
{
    public static function toString($notifyable): ?string
    {
        $notifiables = config('chaski.models.notifiables');

        if (! $notifyable) {
            return null;
        }

        $notifiableTypeId = array_search($notifyable::class, $notifiables);
        if ($notifiableTypeId === false) {
            $notifiableTypeId = 'unknown';
        }

        try {
            return $notifyable->id.'|'.$notifiableTypeId;
        } catch (\Throwable $e) {
            // handle anonymous notification
            return '';
        }
    }

    public static function fromString(?string $value): ?\stdClass
    {
        $items = explode('|', $value);

        if (count($items) !== 2) {
            return null;
        }

        $notifiables = config('chaski.models.notifiables');
        $notifiableType = 'unknown';
        if (isset($notifiables[$items[1]])) {
            $notifiableType = $notifiables[$items[1]];
        }

        $userItems = new \stdClass();
        $userItems->id = $items[0];
        $userItems->type = $notifiableType;

        return $userItems;
    }
}
