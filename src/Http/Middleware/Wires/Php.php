<?php

namespace Yormy\ChaskiLaravel\Http\Middleware\Wires;

use Yormy\ChaskiLaravel\DataObjects\TriggerEventData;
use Yormy\ChaskiLaravel\Observers\Events\Failed\PhpFailedEvent;

class Php extends BaseWire
{
    public const NAME = 'php';

    protected function attackFound(TriggerEventData $triggerEventData): void
    {
        event(new PhpFailedEvent($triggerEventData));

        $this->blockIfNeeded();
    }

    public function getPatterns(): array
    {
        $patterns = [];

        foreach ($this->config->tripwires() as $wire) {
            $patterns[] = '#'.$wire.'#i';
        }

        return $patterns;
    }
}
