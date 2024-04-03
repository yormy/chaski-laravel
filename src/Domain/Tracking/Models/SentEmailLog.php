<?php

namespace Yormy\ChaskiLaravel\Domain\Tracking\Models;

use Illuminate\Database\Eloquent\Model;
use Yormy\CoreToolsLaravel\Traits\Factories\PackageFactoryTrait;

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
    use PackageFactoryTrait;

    protected $table = 'sent_emails_log';

    protected $fillable = [
        'sent_email_id',
        'ip_address',
        'user_agent',
        'type',
        'url',
    ];
}
