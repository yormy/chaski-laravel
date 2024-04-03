<?php

namespace Yormy\ChaskiLaravel\Domain\Tracking\Observers\Listeners;

use jdavidbakr\MailTracker\Events\LinkClickedEvent;
use Yormy\ChaskiLaravel\Services\Resolvers\IpResolver;
use Yormy\ChaskiLaravel\Services\Resolvers\UserAgentResolver;

class EmailClickedListener
{
    public function handle(LinkClickedEvent $event): void
    {
        $tracker = $event->sent_email;

        $sentEmailLogclass = config('chaski.models.sent_email_log');
        $sentEmailLog = new $sentEmailLogclass();
        $sentEmailLog->sent_email_id = $tracker->id;
        $sentEmailLog->type = 'CLICK';
        $sentEmailLog->ip_address = IpResolver::get();
        $sentEmailLog->user_agent = UserAgentResolver::getFullAgent();
        $sentEmailLog->link_url = $event->link_url;

        $sentEmailLog->save();
    }
}
