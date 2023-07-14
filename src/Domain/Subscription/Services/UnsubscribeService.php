<?php

namespace Yormy\ChaskiLaravel\Domain\Subscription\Services;

use Spatie\MailTemplates\Models\MailTemplate;
use Yormy\ChaskiLaravel\Domain\Shared\Services\Encryption;
use Yormy\ChaskiLaravel\Domain\Shared\Services\Locale;
use Yormy\ChaskiLaravel\Domain\Shared\Services\StringableUser;
use Yormy\ChaskiLaravel\Domain\Subscription\Observers\Events\UnsubscribeCompleted;
use Yormy\ChaskiLaravel\Domain\Subscription\Observers\Events\UnsubscribeFailed;
use Yormy\ChaskiLaravel\Domain\Subscription\Observers\Events\UnsubscribePrevented;

class UnsubscribeService
{
    private array $unsubscribeTokenItems;

    public function __construct(private readonly string $unsubscribeToken)
    {
        // ...
        $unsubscribeToken = Encryption::decrypt($unsubscribeToken);
        $this->unsubscribeTokenItems = explode('-', $unsubscribeToken);
    }

    public function execute(): string
    {
        if (count($this->unsubscribeTokenItems) !== 3) {
            event(new UnsubscribeFailed($this->unsubscribeToken));

            return config('chaski.unsubscribe_view.invalid_token');
        }

        $stringableUser = StringableUser::fromString($this->unsubscribeTokenItems[0]);
        $mailableXid = $this->unsubscribeTokenItems[1];

        $userClass = $stringableUser->type;
        $user = $userClass::where('id', $stringableUser->id)->first();
        if (! $user) {
            event(new UnsubscribeFailed($this->unsubscribeToken));

            return config('chaski.unsubscribe_view.invalid_token');
        }

        $mailTemplate = MailTemplate::where('xid', $mailableXid)->first();
        if (! $mailTemplate) {
            event(new UnsubscribeFailed($this->unsubscribeToken));

            return config('chaski.unsubscribe_view.invalid_token');
        }

        if (! $mailTemplate->mail_unsubscribable) {
            event(new UnsubscribePrevented($user, $mailTemplate));

            return config('chaski.unsubscribe_view.prevented');
        }

        $notificationClass = $mailTemplate->notification;
        $user->unsubscribe($notificationClass);

        event(new UnsubscribeCompleted($user, $mailTemplate));

        return config('chaski.unsubscribe_view.success');
    }

    public function getLanguage(): string
    {
        $locale = config('chaski.default_language');
        if (isset($this->unsubscribeTokenItems[2]) && Locale::isValidLanguage($this->unsubscribeTokenItems[2])) {
            $locale = $this->unsubscribeTokenItems[2];
        }

        return $locale;
    }
}
