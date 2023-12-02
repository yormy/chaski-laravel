<?php

namespace Yormy\ChaskiLaravel\Domain\Tracking\Models;

use jdavidbakr\MailTracker\Model\SentEmail as BaseSentEmail;
use Yormy\CoreToolsLaravel\Traits\Factories\PackageFactoryTrait;
use Yormy\Xid\Models\Traits\Xid;

/**
 * Yormy\ChaskiLaravel\Domain\Create\Models\Yormy\ChaskiLaravel\Domain\Create\Models\MailTracker\SentEmail
 *
 * @property-read string|null $content
 * @property-read mixed $recipient
 * @property-read \jdavidbakr\MailTracker\Model\[type] $report_class
 * @property-read mixed $sender
 * @property-read \jdavidbakr\MailTracker\Model\[type] $smtp_info
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \jdavidbakr\MailTracker\Model\SentEmailUrlClicked> $urlClicks
 * @property-read int|null $url_clicks_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SentEmail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SentEmail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SentEmail query()
 *
 * @mixin \Eloquent
 */

/**
 * @psalm-suppress MethodSignatureMustProvideReturnType
 */
class SentEmail extends BaseSentEmail
{
    use Xid;
    use PackageFactoryTrait;
}
