<?php

namespace Yormy\ChaskiLaravel\Observers;

use Illuminate\Events\Dispatcher;
use Yormy\ChaskiLaravel\Observers\Interfaces\LoggableEventInterface;
use Yormy\ChaskiLaravel\Observers\Listeners\LogEvent;

class ChaskiSubscriber
{
    public function subscribe(Dispatcher $events): void
    {
        //        $events->listen(
        //            LoggableEventInterface::class,
        //            LogEvent::class
        //        );
    }
}
