<?php

namespace Yormy\ChaskiLaravel\Domain\Shared\Services;

class Locale
{
    public static function isValidLanguage(string $locale): bool
    {
        if (! in_array($locale, config('chaski.languages'))) {
            return false;
        }

        return true;
    }
}
