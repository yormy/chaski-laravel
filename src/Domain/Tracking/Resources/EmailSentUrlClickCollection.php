<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Tracking\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EmailSentUrlClickCollection extends ResourceCollection
{
    public $collects = EmailSentUrlClickResource::class;
}
