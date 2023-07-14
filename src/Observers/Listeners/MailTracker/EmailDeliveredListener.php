<?php

namespace Yormy\ChaskiLaravel\Observers\Listeners\MailTracker;

use Carbon\Carbon;
use jdavidbakr\MailTracker\Events\EmailDeliveredEvent;
use Yormy\ChaskiLaravel\Observers\Listeners\MailTracker\Traits\MailTrackerUserTrait;

class EmailDeliveredListener
{
    use MailTrackerUserTrait;

    /**
     * @psalm-suppress UndefinedClass
     */
    public function handle(EmailDeliveredEvent $event): void
    {
        $user = $this->getUser($event->sent_email);

        if ($user) {
            $tracker = $event->sent_email;
            $tracker->user_id = $user->id;
            $tracker->user_type = get_class($user);
            $tracker->status_delivered = Carbon::now();
            $tracker->save();
        }
    }
}
