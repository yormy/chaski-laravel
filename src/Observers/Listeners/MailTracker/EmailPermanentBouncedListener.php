<?php

namespace Yormy\ChaskiLaravel\Observers\Listeners\MailTracker;

use jdavidbakr\MailTracker\Events\PermanentBouncedMessageEvent;
use Yormy\ChaskiLaravel\Observers\Listeners\MailTracker\Traits\MailTrackerUserTrait;

class EmailPermanentBouncedListener
{
    use MailTrackerUserTrait;

    /**
     * @psalm-suppress UndefinedClass
     */
    public function handle(PermanentBouncedMessageEvent $event): void
    {
        $user = $this->getUser($event->sent_email);

        if ($user) {
            $tracker = $event->sent_email;
            $tracker->user_id = $user->id;
            $tracker->user_type = get_class($user);
            $tracker->status_bounced = 'PERMANENT';
            $tracker->save();
        }
    }
}
