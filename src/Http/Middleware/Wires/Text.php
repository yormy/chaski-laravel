<?php

namespace Yormy\ChaskiLaravel\Http\Middleware\Wires;

use Yormy\ChaskiLaravel\DataObjects\TriggerEventData;
use Yormy\ChaskiLaravel\Observers\Events\Failed\TextFailedEvent;

class Text extends BaseWire
{
    public const NAME = 'text';

    protected function attackFound(TriggerEventData $triggerEventData): void
    {
        event(new TextFailedEvent($triggerEventData));

        $this->blockIfNeeded();
    }

    /**
     * @return void
     */
    public function matchResults($pattern, string $input, &$violations)
    {
        if (str_contains($input, $pattern)) {
            $violations[] = $pattern;
        }
    }
}
