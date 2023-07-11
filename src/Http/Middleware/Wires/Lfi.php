<?php

namespace Yormy\ChaskiLaravel\Http\Middleware\Wires;

use Yormy\ChaskiLaravel\DataObjects\TriggerEventData;
use Yormy\ChaskiLaravel\Observers\Events\Failed\LfiFailedEvent;

class Lfi extends BaseWire
{
    public const NAME = 'lfi';

    protected function attackFound(TriggerEventData $triggerEventData): void
    {
        event(new LfiFailedEvent($triggerEventData));

        $this->blockIfNeeded();
    }
}
