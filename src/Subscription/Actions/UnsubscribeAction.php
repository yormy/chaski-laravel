<?php

namespace Yormy\ChaskiLaravel\Subscription\Actions;

use Spatie\MailTemplates\Models\MailTemplate;
use Yormy\ChaskiLaravel\Services\StringableUser;
use Yormy\ChaskiLaravel\Subscription\Observers\Events\UnsubscribePrevented;
use Yormy\ChaskiLaravel\Subscription\Observers\Events\UnsubscribeCompleted;

class UnsubscribeAction
{
    public static function execute(string $unsubscribeToken): bool
    {
        $tokenItems = explode('|', $unsubscribeToken);
        $stringableUser = StringableUser::fromString($tokenItems[0]);
        $mailableXid = $tokenItems[1];

        $userClass = $stringableUser->type;
        $user = $userClass::where('id', $stringableUser->id)->firstOrFail();

        $mailTemplate = MailTemplate::where('xid', $mailableXid)->firstOrFail();

        if (! $mailTemplate->mail_preventable) {
            event(new UnsubscribePrevented($user, $mailTemplate));
            return false;
        }

        $notificationClass = $mailTemplate->notification;
        $user->unsubscribe($notificationClass);

        event(new UnsubscribeCompleted($user, $mailTemplate));

        return true;
    }
}
