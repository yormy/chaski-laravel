<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Tracking\Models;

use Illuminate\Database\Eloquent\Model;
use Yormy\CoreToolsLaravel\Traits\Factories\PackageFactoryTrait;
use Yormy\Dateformatter\Models\Traits\DateFormatter;

/**
 * @property-read string|null $created_at_humans
 *
 *
 * @mixin \Eloquent
 */
class NotificationSent extends Model
{
    use DateFormatter;
    use PackageFactoryTrait;

    protected $table = 'notifications';

    protected $casts = [
        'id' => 'string',
        'read_at' => 'datetime',
    ];
}
