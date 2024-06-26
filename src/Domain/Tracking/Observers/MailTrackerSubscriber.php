<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Tracking\Observers;

use Illuminate\Events\Dispatcher;
use jdavidbakr\MailTracker\Events\ComplaintMessageEvent;
use jdavidbakr\MailTracker\Events\EmailDeliveredEvent;
use jdavidbakr\MailTracker\Events\EmailSentEvent;
use jdavidbakr\MailTracker\Events\LinkClickedEvent;
use jdavidbakr\MailTracker\Events\PermanentBouncedMessageEvent;
use jdavidbakr\MailTracker\Events\ViewEmailEvent;
use Yormy\ChaskiLaravel\Domain\Tracking\Observers\Listeners\EmailClickedListener;
use Yormy\ChaskiLaravel\Domain\Tracking\Observers\Listeners\EmailComplaintListener;
use Yormy\ChaskiLaravel\Domain\Tracking\Observers\Listeners\EmailDeliveredListener;
use Yormy\ChaskiLaravel\Domain\Tracking\Observers\Listeners\EmailPermanentBouncedListener;
use Yormy\ChaskiLaravel\Domain\Tracking\Observers\Listeners\EmailSentListener;
use Yormy\ChaskiLaravel\Domain\Tracking\Observers\Listeners\EmailViewedListener;

class MailTrackerSubscriber
{
    /**
     * Binding of SettingsChanged Events
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(
            EmailSentEvent::class,
            EmailSentListener::class
        );

        $events->listen(
            EmailDeliveredEvent::class,
            EmailDeliveredListener::class
        );

        $events->listen(
            ComplaintMessageEvent::class,
            EmailComplaintListener::class
        );

        $events->listen(
            PermanentBouncedMessageEvent::class,
            EmailPermanentBouncedListener::class
        );

        $events->listen(
            ViewEmailEvent::class,
            EmailViewedListener::class
        );

        $events->listen(
            LinkClickedEvent::class,
            EmailClickedListener::class
        );
    }
}
