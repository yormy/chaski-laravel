<?php

namespace Yormy\ChaskiLaravel\Http\Middleware\Wires;

use Yormy\ChaskiLaravel\DataObjects\TriggerEventData;
use Yormy\ChaskiLaravel\Observers\Events\Failed\CustomFailedEvent;

class Custom extends BaseWire
{
    public const NAME = 'custom';

    protected function attackFound(TriggerEventData $triggerEventData): void
    {
        event(new CustomFailedEvent($triggerEventData));

        $this->blockIfNeeded();
    }
}
