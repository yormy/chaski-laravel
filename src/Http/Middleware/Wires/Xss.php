<?php

namespace Yormy\ChaskiLaravel\Http\Middleware\Wires;

use Yormy\ChaskiLaravel\DataObjects\TriggerEventData;
use Yormy\ChaskiLaravel\Observers\Events\Failed\XssFailedEvent;

class Xss extends BaseWire
{
    public const NAME = 'xss';

    protected function attackFound(TriggerEventData $triggerEventData): void
    {
        event(new XssFailedEvent($triggerEventData));

        $this->blockIfNeeded();
    }
}
