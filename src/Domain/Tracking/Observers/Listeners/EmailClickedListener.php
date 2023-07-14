<?php

namespace Yormy\ChaskiLaravel\Domain\Tracking\Observers\Listeners;

use jdavidbakr\MailTracker\Events\LinkClickedEvent;
use Yormy\ChaskiLaravel\Domain\Shared\Services\IpAddress;

class EmailClickedListener
{
    public function handle(LinkClickedEvent $event): void
    {
        $tracker = $event->sent_email;

        $sentEmailLogclass = config('chaski.models.sent_email_log');
        $sentEmailLog = new $sentEmailLogclass();
        $sentEmailLog->sent_email_id = $tracker->id;
        $sentEmailLog->type = 'CLICK';
        $sentEmailLog->ip_address = IpAddress::get();

        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $sentEmailLog->user_agent = $_SERVER['HTTP_USER_AGENT'];
        }

        $sentEmailLog->save();
    }
}
