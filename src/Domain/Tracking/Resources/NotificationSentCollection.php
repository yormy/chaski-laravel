<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Tracking\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationSentCollection extends ResourceCollection
{
    public $collects = NotificationSentResource::class;
}
