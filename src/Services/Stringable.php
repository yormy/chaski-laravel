<?php

namespace Yormy\ChaskiLaravel\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class Stringable
{
    public static function toString($mailable): ?string
    {
        return Crypt::encryptString($mailable);
    }

    public static function fromString(?string $value): ?string
    {
        if (!$value) {
            return null;
        }

        return Crypt::decryptString($value);
    }
}
