<?php

namespace Yormy\ChaskiLaravel\Domain\Tracking\Models;

use jdavidbakr\MailTracker\Model\SentEmail as BaseSentEmail;
use Yormy\CoreToolsLaravel\Traits\Factories\PackageFactoryTrait;
use Yormy\Xid\Models\Traits\Xid;

class SentEmail extends BaseSentEmail
{
    use Xid;
    use PackageFactoryTrait;

    public function urlsClicked()
    {
        return $this->hasMany(SentEmailUrlClicked::class, 'sent_email_id')->orderBy('created_at', 'desc');
    }

    public function logs()
    {
        return $this->hasMany(SentEmailLog::class, 'sent_email_id')->orderBy('created_at', 'desc');
    }
}
