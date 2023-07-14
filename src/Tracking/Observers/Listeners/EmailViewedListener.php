<?php

namespace Yormy\ChaskiLaravel\Tracking\Observers\Listeners;

use jdavidbakr\MailTracker\Events\ViewEmailEvent;
use Yormy\ChaskiLaravel\Shared\Services\IpAddress;

class EmailViewedListener
{
    public function handle(ViewEmailEvent $event): void
    {
        $tracker = $event->sent_email;

        $sentEmailLogclass = config('chaski.models.sent_email_log');
        $sentEmailLog = new $sentEmailLogclass();
        $sentEmailLog->sent_email_id = $tracker->id;
        $sentEmailLog->type = 'OPEN';
        $sentEmailLog->ip_address = IpAddress::get();

        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $sentEmailLog->user_agent = $_SERVER['HTTP_USER_AGENT'];
        }

        $sentEmailLog->save();
    }
}
