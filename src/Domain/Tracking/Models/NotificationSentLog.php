<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Tracking\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSentLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSentLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSentLog query()
 *
 * @mixin \Eloquent
 */
class NotificationSentLog extends Model
{
    protected $table = 'notifications_log';

    protected $fillable = [
        'notification_id',
        'ip_address',
        'user_agent',
        'opened_at',
        'actioned_at',
    ];
}
