<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\ServiceProviders;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Yormy\ChaskiLaravel\Domain\Tracking\Observers\MailTrackerSubscriber;
use Yormy\ChaskiLaravel\Observers\ChaskiSubscriber;

class EventServiceProvider extends ServiceProvider
{
    protected $subscribe = [
        ChaskiSubscriber::class,
        MailTrackerSubscriber::class,
    ];
}
