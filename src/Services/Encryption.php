<?php

namespace Yormy\ChaskiLaravel\Services;

use Illuminate\Support\Facades\Crypt;

class Encryption
{
    public static function encrypt($mailable): ?string
    {
        return Crypt::encryptString($mailable);
    }

    public static function decrypt(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return null;
        }
    }
}
