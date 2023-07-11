<?php

namespace Yormy\ChaskiLaravel\Http\Middleware\Blockers;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Yormy\ChaskiLaravel\DataObjects\Config\HtmlResponseConfig;
use Yormy\ChaskiLaravel\DataObjects\Config\JsonResponseConfig;
use Yormy\ChaskiLaravel\Services\ResponseDeterminer;
use Yormy\ChaskiLaravel\Services\UrlTester;

abstract class TripwireBlockHandler
{
    abstract protected function isBlockedUntil(Request $request): ?Carbon;

    /**
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (UrlTester::skipUrl($request, config('tripwire.urls'))) {
            return $next($request);
        }

        if (! $blockedUntil = $this->isBlockedUntil($request)) {
            return $next($request);
        }

        if ($request->wantsJson()) {
            $config = JsonResponseConfig::makeFromArray(config('tripwire.block_response.json'));
            $respond = new ResponseDeterminer($config);

            return $respond->respondWithJson(['blocked_until' => $blockedUntil]);
        }

        $config = HtmlResponseConfig::makeFromArray(config('tripwire.block_response.html'));
        $respond = new ResponseDeterminer($config);

        return $respond->respondWithHtml(['blocked_until' => $blockedUntil]);
    }
}
