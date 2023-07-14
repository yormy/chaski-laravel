<?php

namespace Yormy\ChaskiLaravel\Subscription\Observers\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Spatie\MailTemplates\Models\MailTemplate;

class UnsubscribePrevented
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        protected $user,
        protected readonly MailTemplate $mailTemplate
    ) {
    }
}
