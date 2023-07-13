<?php

namespace Yormy\ChaskiLaravel\Models\MailTracker;

use Illuminate\Database\Eloquent\Model;

/**
 * Yormy\ChaskiLaravel\Models\MailTracker\SentEmailLog
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SentEmailLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SentEmailLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SentEmailLog query()
 *
 * @mixin \Eloquent
 */
class SentEmailLog extends Model
{
    protected $table = 'sent_emails_log';
}
