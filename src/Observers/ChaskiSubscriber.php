<?php

namespace Yormy\ChaskiLaravel\Observers;

use Illuminate\Events\Dispatcher;
use Yormy\ChaskiLaravel\Observers\Events\Tripwires\PageNotFoundEvent;
use Yormy\ChaskiLaravel\Observers\Events\Tripwires\RouteModelBindingFailedEvent;
use Yormy\ChaskiLaravel\Observers\Events\Tripwires\ThrottleHitEvent;
use Yormy\ChaskiLaravel\Observers\Interfaces\LoggableEventInterface;
use Yormy\ChaskiLaravel\Observers\Listeners\LogEvent;
use Yormy\ChaskiLaravel\Observers\Listeners\Tripwires\PageNotFoundWireListener;
use Yormy\ChaskiLaravel\Observers\Listeners\Tripwires\RouteModelBindingWireListener;
use Yormy\ChaskiLaravel\Observers\Listeners\Tripwires\ThrottleHitWireListener;

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
