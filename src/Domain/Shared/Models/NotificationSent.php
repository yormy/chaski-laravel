<?php

namespace Yormy\ChaskiLaravel\Domain\Shared\Models;

use Illuminate\Database\Eloquent\Model;
use Yormy\CoreToolsLaravel\Traits\Factories\PackageFactoryTrait;

class NotificationSent extends Model
{
    use PackageFactoryTrait;

    protected $table = 'notifications';

    protected $casts = [
        'read_at' => 'datetime'
    ];
}
