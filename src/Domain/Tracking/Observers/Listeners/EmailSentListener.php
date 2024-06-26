<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Tracking\Observers\Listeners;

use jdavidbakr\MailTracker\Events\EmailSentEvent;
use Yormy\ChaskiLaravel\Domain\Tracking\Models\SentEmail;
use Yormy\ChaskiLaravel\Domain\Tracking\Observers\Listeners\Traits\MailTrackerUserTrait;

/**
 * @psalm-suppress UndefinedMagicPropertyAssignment
 */
class EmailSentListener
{
    use MailTrackerUserTrait;

    /**
     * @psalm-suppress UndefinedClass
     */
    public function handle(EmailSentEvent $event): void
    {
        $this->updateTrackingData($event);
    }

    private function updateTrackingData(EmailSentEvent $event): SentEmail
    {
        $userItems = $this->getUser($event->sent_email);

        /**
         * @var SentEmail $tracker
         */
        $tracker = $event->sent_email;

        if ($userItems) {
            $tracker->user_id = $userItems->id;
            $tracker->user_type = $userItems->type;
        }

        $mailable = $this->getMailable($event->sent_email);
        if ($mailable) {
            $tracker->mailable_type = $mailable;
        }

        if ($this->isPreventContentStoring($event->sent_email)) {
            $tracker->content = config('chaski.prevented_content_logging');
        }

        $notificationUuid = $this->getNotificationUuid($event->sent_email);

        $tracker->sent_email_id = $notificationUuid;

        $tracker->save();

        return $tracker;
    }
}
