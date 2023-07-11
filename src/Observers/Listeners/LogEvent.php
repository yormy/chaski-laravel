<?php

namespace Yormy\ChaskiLaravel\Observers\Listeners;

use Yormy\ChaskiLaravel\Jobs\AddLogJob;
use Yormy\ChaskiLaravel\Services\LogRequestService;

class LogEvent extends BaseListener
{
    /**
     * @return void
     */
    public function handle($event)
    {
        $meta = LogRequestService::getMeta($this->request);

        AddLogJob::dispatch(
            event: $event,
            meta: $meta,
        );
    }
}
