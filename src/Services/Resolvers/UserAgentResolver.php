<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Services\Resolvers;

use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class UserAgentResolver
{
    public static function get(): string
    {
        $agent = new Agent();
        $platform = $agent->platform();
        $userAgent = $platform.' '.$agent->version($platform);

        $browser = $agent->browser();

        return $userAgent.$browser.' '.$agent->version($browser);
    }

    public static function getFullAgent(?Request $request = null): string
    {
        if (! $request) {
            return $_SERVER['HTTP_USER_AGENT'] ?? '';
        }

        return $request->server('HTTP_USER_AGENT');
    }
}
