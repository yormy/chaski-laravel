<?php

namespace Yormy\ChaskiLaravel\Http\Middleware\Wires;

use Yormy\ChaskiLaravel\DataObjects\TriggerEventData;
use Yormy\ChaskiLaravel\Observers\Events\Failed\SessionFailedEvent;

class Session extends BaseWire
{
    public const NAME = 'session';

    protected function attackFound(TriggerEventData $triggerEventData): void
    {
        event(new SessionFailedEvent($triggerEventData));

        $this->blockIfNeeded();
    }
}
