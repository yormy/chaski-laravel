<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Tracking\Observers\Listeners;

use jdavidbakr\MailTracker\Events\PermanentBouncedMessageEvent;
use Yormy\ChaskiLaravel\Domain\Tracking\Observers\Listeners\Traits\MailTrackerUserTrait;

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
            $tracker->user_type = $user::class;
            $tracker->status_bounced = 'PERMANENT';
            $tracker->save();
        }
    }
}
