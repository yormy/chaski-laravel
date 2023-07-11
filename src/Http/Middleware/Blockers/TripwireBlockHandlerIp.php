<?php

namespace Yormy\ChaskiLaravel\Http\Middleware\Blockers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Yormy\ChaskiLaravel\Repositories\BlockRepository;

class TripwireBlockHandlerIp extends TripwireBlockHandler
{
    protected function isBlockedUntil(Request $request): ?Carbon
    {
        $ipAddressClass = config('tripwire.services.ip_address');
        $ipAddress = $ipAddressClass::get($request);

        $blockRepository = new BlockRepository();

        return $blockRepository->isIpBlockedUntil($ipAddress);
    }
}
