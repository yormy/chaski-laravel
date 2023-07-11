<?php

namespace Yormy\ChaskiLaravel\Observers\Listeners\MailTracker\Traits;

use jdavidbakr\MailTracker\Model\SentEmail;
use Yormy\ChaskiLaravel\Services\Stringable;
use Yormy\ChaskiLaravel\Services\StringableUser;

trait MailTrackerUserTrait
{
    public function getUser(SentEmail $sentEmail): ? \stdClass
    {
        $stringedUser = $sentEmail->getHeader('X-UXID');

        $user = StringableUser::fromString($stringedUser);

        return $user;
    }

    public function getMailable(SentEmail $sentEmail): ?string
    {
        $mailable = $sentEmail->getHeader('X-MX');

        return Stringable::fromString($mailable);
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
