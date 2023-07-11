<?php

namespace Yormy\ChaskiLaravel\Http\Middleware\Wires;

use Yormy\ChaskiLaravel\DataObjects\TriggerEventData;
use Yormy\ChaskiLaravel\Observers\Events\Failed\BotFailedEvent;
use Yormy\ChaskiLaravel\Services\RequestSource;

class Bot extends BaseWire
{
    public const NAME = 'bot';

    protected function attackFound(TriggerEventData $triggerEventData): void
    {
        event(new BotFailedEvent($triggerEventData));

        $this->blockIfNeeded();
    }

    public function isAttack($patterns): bool
    {
        if (! RequestSource::isRobot()) {
            return false;
        }

        $robot = RequestSource::getRobot();

        return $this->isFilterAttack($robot, $this->config->filters());
    }
}
