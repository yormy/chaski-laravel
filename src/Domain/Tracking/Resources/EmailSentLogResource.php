<?php declare(strict_types=1);

namespace Yormy\ChaskiLaravel\Domain\Tracking\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmailSentLogResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent,
            'type' => $this->type,
            'url' => $this->url,
            'created_at' => $this->created_at,
        ];

        return $data;
    }
}
