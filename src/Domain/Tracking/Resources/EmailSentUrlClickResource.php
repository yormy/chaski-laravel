<?php

declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Tracking\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmailSentUrlClickResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'url' => $this->url,
            'clicks' => $this->clicks,
            'created_at' => $this->created_at,
        ];

        return $data;
    }
}
