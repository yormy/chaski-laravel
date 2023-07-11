<?php

namespace Yormy\ChaskiLaravel\Observers;

use Illuminate\Events\Dispatcher;
use jdavidbakr\MailTracker\Events\ComplaintMessageEvent;
use jdavidbakr\MailTracker\Events\EmailDeliveredEvent;
use jdavidbakr\MailTracker\Events\EmailSentEvent;
use jdavidbakr\MailTracker\Events\LinkClickedEvent;
use jdavidbakr\MailTracker\Events\PermanentBouncedMessageEvent;
use jdavidbakr\MailTracker\Events\ViewEmailEvent;
use Yormy\ChaskiLaravel\Observers\Listeners\MailTracker\EmailClickedListener;
use Yormy\ChaskiLaravel\Observers\Listeners\MailTracker\EmailComplaintListener;
use Yormy\ChaskiLaravel\Observers\Listeners\MailTracker\EmailDeliveredListener;
use Yormy\ChaskiLaravel\Observers\Listeners\MailTracker\EmailPermanentBouncedListener;
use Yormy\ChaskiLaravel\Observers\Listeners\MailTracker\EmailSentListener;
use Yormy\ChaskiLaravel\Observers\Listeners\MailTracker\EmailViewedListener;

class MailTrackerSubscriber
{
    /**
     * Binding of SettingsChanged Events
     *
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
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
