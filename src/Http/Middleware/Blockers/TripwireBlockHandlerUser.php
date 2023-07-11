<?php

namespace Yormy\ChaskiLaravel\Http\Middleware\Blockers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Yormy\ChaskiLaravel\Repositories\BlockRepository;

class TripwireBlockHandlerUser extends TripwireBlockHandler
{
    protected function isBlockedUntil(Request $request): ?Carbon
    {
        $userClass = config('tripwire.services.user');
        $userId = $userClass::getId($request);

        if (! $userId) {
            return null;
        }

        $userType = $userClass::getType($request);

        $blockRepository = new BlockRepository();

        return $blockRepository->isUserBlockedUntil($userId, $userType);
    }
}
