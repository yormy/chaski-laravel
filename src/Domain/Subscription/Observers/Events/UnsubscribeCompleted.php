<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Subscription\Observers\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Spatie\MailTemplates\Models\MailTemplate;

class UnsubscribeCompleted
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        protected $user,
        protected readonly MailTemplate $mailTemplate
    ) {
    }
}
