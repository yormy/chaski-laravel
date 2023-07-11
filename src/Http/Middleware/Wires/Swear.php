<?php

namespace Yormy\ChaskiLaravel\Http\Middleware\Wires;

use Yormy\ChaskiLaravel\DataObjects\TriggerEventData;
use Yormy\ChaskiLaravel\Observers\Events\Failed\SwearFailedEvent;

class Swear extends BaseWire
{
    public const NAME = 'SWEARY';

    protected function attackFound(TriggerEventData $triggerEventData): void
    {
        event(new SwearFailedEvent($triggerEventData));

        $this->blockIfNeeded();
    }

    /**
     * @return string[]
     *
     * @psalm-return list{0?: string,...}
     */
    public function getPatterns()
    {
        $patterns = [];

        foreach ($this->config->tripwires() as $wire) {
            $patterns[] = '#\b'.$wire.'\b#i';
        }

        return $patterns;
    }
}
