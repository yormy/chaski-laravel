<?php

namespace Yormy\ChaskiLaravel\Domain\Tracking\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Yormy\ChaskiLaravel\Domain\Tracking\Models\SentEmailLog
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
