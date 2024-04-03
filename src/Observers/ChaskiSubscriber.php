<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Observers;

use Illuminate\Events\Dispatcher;

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
