<?php

namespace Yormy\ChaskiLaravel\Observers\Listeners\MailTracker;

use jdavidbakr\MailTracker\Events\ComplaintMessageEvent;
use Yormy\ChaskiLaravel\Observers\Listeners\MailTracker\Traits\MailTrackerUserTrait;

class EmailComplaintListener
{
    use MailTrackerUserTrait;

    /**
     * @psalm-suppress UndefinedClass
     */
    public function handle(ComplaintMessageEvent $event)
    {
        $user = $this->getUser($event->sent_email);

        if ($user) {
            $tracker = $event->sent_email;
            $tracker->user_id = $user->id;
            $tracker->user_type = get_class($user);
            $tracker->status_complaint = json_encode($event);
            $tracker->save();
        }
    }
}
