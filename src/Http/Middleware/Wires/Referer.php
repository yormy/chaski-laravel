<?php

namespace Yormy\ChaskiLaravel\Http\Middleware\Wires;

use Yormy\ChaskiLaravel\DataObjects\TriggerEventData;
use Yormy\ChaskiLaravel\Observers\Events\Failed\RefererFailedEvent;
use Yormy\ChaskiLaravel\Services\RequestSource;

class Referer extends BaseWire
{
    public const NAME = 'referer';

    protected function attackFound(TriggerEventData $triggerEventData): void
    {
        event(new RefererFailedEvent($triggerEventData));

        $this->blockIfNeeded();
    }

    public function isAttack($patterns): bool
    {
        $referer = RequestSource::getReferer();

        return $this->isFilterAttack($referer, $this->config->filters());
    }
}
