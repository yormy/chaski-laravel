<?php

namespace Yormy\ChaskiLaravel\Tracking\Observers\Listeners\Traits;

use jdavidbakr\MailTracker\Model\SentEmail;
use Yormy\ChaskiLaravel\Shared\Services\Encryption;
use Yormy\ChaskiLaravel\Shared\Services\StringableUser;

trait MailTrackerUserTrait
{
    public function getUser(SentEmail $sentEmail): ?\stdClass
    {
        $stringedUser = $sentEmail->getHeader('X-UXID');

        $user = StringableUser::fromString(Encryption::decrypt($stringedUser));

        return $user;
    }

    public function getMailable(SentEmail $sentEmail): ?string
    {
        $mailable = $sentEmail->getHeader('X-MX');

        return Encryption::decrypt($mailable);
    }

    public function isPreventContentStoring(SentEmail $sentEmail): bool
    {
        $mailTemplateName = $this->getMailable($sentEmail);

        if (in_array($mailTemplateName, config('chaski.mail_tracker.prevent_content_logging'))) {
            return true;
        }

        return false;
    }
}
