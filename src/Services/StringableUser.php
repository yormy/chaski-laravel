<?php

namespace Yormy\ChaskiLaravel\Services;

class StringableUser
{
    public static function toString($notifyable): ?string
    {
        $notifiables = config('chaski.models.notifiables');

        if (! $notifyable) {
            return null;
        }

        $notifiableTypeId = array_search(get_class($notifyable), $notifiables);
        if ($notifiableTypeId === false) {
            $notifiableTypeId = 'unknown';
        }

        $string = $notifyable->id.'|'.$notifiableTypeId;

        return Stringable::toString($string);
    }

    public static function fromString(?string $value): ?\stdClass
    {
        $decrypted = Stringable::fromString($value);

        $items = explode('|', $decrypted);

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
