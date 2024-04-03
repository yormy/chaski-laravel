<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Tracking\Observers\Listeners\Traits;

use jdavidbakr\MailTracker\Model\SentEmail;
use Yormy\ChaskiLaravel\Domain\Shared\Services\Encryption;
use Yormy\ChaskiLaravel\Domain\Shared\Services\StringableUser;

trait MailTrackerUserTrait
{
    public function getUser(SentEmail $sentEmail): ?\stdClass
    {
        $stringedUser = $sentEmail->getHeader('X-UXID');

        return StringableUser::fromString(Encryption::decrypt($stringedUser));
    }

    public function getMailable(SentEmail $sentEmail): ?string
    {
        $mailable = $sentEmail->getHeader('X-MX');

        return Encryption::decrypt($mailable);
    }

    public function getNotificationUuid(SentEmail $sentEmail): ?string
    {
        $notificationUuid = $sentEmail->getHeader('X-NX');

        return Encryption::decrypt($notificationUuid);
    }

    public function isPreventContentStoring(SentEmail $sentEmail): bool
    {
        $mailTemplateName = $this->getMailable($sentEmail);

        if (! $mailTemplateName || ! $mailTemplateName::ALLOW_CONTENT_LOGGING || in_array($mailTemplateName, config('chaski.mail_tracker.prevent_content_logging'))) {
            return true;
        }

        return false;
    }
}
