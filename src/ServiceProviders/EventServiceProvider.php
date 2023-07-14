<?php

namespace Yormy\ChaskiLaravel\ServiceProviders;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Yormy\ChaskiLaravel\Observers\ChaskiSubscriber;
use Yormy\ChaskiLaravel\Domain\Tracking\Observers\MailTrackerSubscriber;

class EventServiceProvider extends ServiceProvider
{
    protected $subscribe = [
        ChaskiSubscriber::class,
        MailTrackerSubscriber::class,
    ];
}
