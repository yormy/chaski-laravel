<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Subscription\Observers\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UnsubscribeFailed
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        protected string $unsubscribeToken,
    ) {
    }
}
