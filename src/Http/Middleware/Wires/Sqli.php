<?php

namespace Yormy\ChaskiLaravel\Http\Middleware\Wires;

use Yormy\ChaskiLaravel\DataObjects\TriggerEventData;
use Yormy\ChaskiLaravel\Observers\Events\Failed\SqliFailedEvent;

class Sqli extends BaseWire
{
    public const NAME = 'sqli';

    protected function attackFound(TriggerEventData $triggerEventData): void
    {
        event(new SqliFailedEvent($triggerEventData));

        $this->blockIfNeeded();
    }
}
