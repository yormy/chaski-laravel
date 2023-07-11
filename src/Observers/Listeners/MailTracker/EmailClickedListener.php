<?php

namespace Yormy\ChaskiLaravel\Observers\Listeners\MailTracker;

use jdavidbakr\MailTracker\Events\LinkClickedEvent;
use Yormy\ChaskiLaravel\Models\MailTracker\SentEmailLog;
use Yormy\ChaskiLaravel\Services\IpAddress;

class EmailClickedListener
{
    /**
     * @param LinkClickedEvent $event
     */
    public function handle(LinkClickedEvent $event)
    {
        $tracker = $event->sent_email;

        $sentEmailLogclass = config('chaski.models.sent_email_log');
        $sentEmailLog = new $sentEmailLogclass();
        $sentEmailLog->sent_email_id = $tracker->id;
        $sentEmailLog->type = "CLICK";
        $sentEmailLog->ip_address = IpAddress::get();

        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $sentEmailLog->user_agent = $_SERVER['HTTP_USER_AGENT'];
        }

        $sentEmailLog->save();
    }
}
